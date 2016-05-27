<?php
namespace common\models;

use Yii;
use common\api\VsoApi;
use yii\helpers\ArrayHelper;

/**
 * 上传图片
 *
 */
class Industry
{
    /**
     * 获取分类，构造一个数组，第一维为一级分类，第二维为二级分类，第三维为三级分类，每一级的节点
     * 有三个键值，id(int)-分类id；name(string)-分类名称；children(Array)-子类
     * 注意：三级分类不存在的时候可能会导致异常
     */
    public static function getApiIndustryList()
    {
        $redis = yii::$app->redis;
        //从缓存中获取数据
        $data = Yii::$app->redis->get('Growth_Rc_industryArray');
        if ($data) {
            return $data = json_decode($data, true);
        }

        $cats = self::getApiIndustries();
        if (!$cats) {
            return [];
        }
        $arr = array();
        $root = $a = $lvl = 0;
        $levemore =false;
        foreach ($cats as $v) {
            $item = array('id' => $v['id'], 'old_indus_id' => $v['old_indus_id'], 'name' => $v['name']);
            if ($root && $root != $v['root']) {
                $root = 0;
            }
            if ($v['lvl'] < $lvl && $lvl) {
                $a = $lvl = 0;

            }
            if ($v['lvl'] > $lvl) {
                $lvl = $v['lvl'];
            }

            if ($v['lvl'] === 0) {
                if ($root === 0) {
                    $root = $v['root'];
                }
                $arr[$root] = $item;
            }
            if ($v['lvl'] === 1) {
                if ($a === 0) {
                    $a = $v['id'];
                }
                if($levemore){
                    $arr[$root]['children'][$v['id']] = $item;
                }else{
                    $arr[$root]['children'][$a] = $item;
                }
            }
            if ($v['lvl'] === 2) {
                $levemore =true;
                $arr[$root]['children'][$a]['children'][] = $item;
            }
        }

        // 将 $data 存放到缓存供下次使用
        $expireTime = \Yii::$app->params['catExpireTime'];
        $redis->setex('Growth_Rc_industryArray', $expireTime, json_encode($arr));
        return $arr;
    }

    /**
     * 获取子节点
     */
    public static function getAllChildren($node, $cats)
    {
        $childArr = [];
        foreach ($cats as $cat) {
            if ($node['lft'] < $cat['lft'] && $node['rgt'] > $cat['rgt'] && $node['root'] == $cat['root']) {
                $childArr[] = $cat;
            }
        }
        return $childArr;
    }

    /**
     * 通过节点id获取节点信息
     */
    public static function getNodeInfo($id)
    {
        $data = Yii::$app->redis->get('Maker_Rc_industryList');
        $info = array(
            'name' => ''
        );
        if (!$data) {
            $expireTime = \Yii::$app->params['catExpireTime'];
            // 将 $data 存放到缓存供下次使用
            $data = self::getApiIndustries();
            $redis = yii::$app->redis;
            $redis->setex('Maker_Rc_industryList', $expireTime, json_encode($data));
        } else {
            $data = json_decode($data, true);
        }
        foreach ($data as $val) {
            if ($val['id'] == $id) {
                $info['name'] = $val['name'];
            }

        }

        return $info;
    }

    /**
     * 获取接口数据
     */
    public static function getApiIndustries()
    {

        $url = yii::$app->params['industryListUrl'];
        $data = [
        ];
        $cats = VsoApi::send($url, $data, $type = "get");
        if (!$cats['data']) {
            return [];
        } else {
            return $cats['data'];
        }

    }

    /**
     * 从缓存中获取分类数据
     */
    public static function getIndustryList()
    {
        // 尝试从缓存中取回 $data
        $data = yii::$app->redis->get('Maker_Rc_catList');
        if (!$data) {
            $expireTime = \Yii::$app->params['catExpireTime'];
            // 将 $data 存放到缓存供下次使用
            $data = Industry::getApiIndustryList();
            $redis = yii::$app->redis;
            $redis->setex('Maker_Rc_catList', $expireTime, json_encode($data));
        } else {
            $data = json_decode($data, true);
        }
        return $data;
    }

    /**
     * 三级分类联动需要的json结构
     * 前台调用方式是bui的二级联动，然后是静态调用方式
     * json格式如下
     * $jsonStr = '[{"id":"1","text":"山东","children":[{"id":"11","text":"济南","leaf":false,"children":[{"id":"121","text":"斯蒂芬撒旦区","leaf":true},
     * {"id":"121","text":"斯蒂芬斯蒂芬","leaf":true}]},{"id":"12","text":"淄博","leaf":false,"children":[{"id":"121","text":"淄川区","leaf":true},
     * {"id":"121","text":"某区","leaf":true}]}]},{"id":"2","text":"广东","children":[{"id":"21","text":"广州","leaf":false,"children":[{"id":"211","text":"花都区","leaf":true},
     * {"id":"211","text":"海珠区","leaf":true}]},{"id":"22","text":"茂名","leaf":false,"children":[{"id":"221","text":"化区","leaf":true}]}]}]';
     *
     */
    public static function getIndustryJson($indArr = [])
    {
        /**
         * 重拼三级分类需要的数组结构
         *
         */
        $cateArr = array();
        $pArr = Industry::getApiIndustryList();
        $i = 0;
        foreach ($pArr as $aitem) {
            $item = array();
            $item['id'] = "{$aitem['id']}";
            $item['old_id'] = "{$aitem['old_indus_id']}";
            $item['text'] = $aitem['name'];
            $item['level'] = 0;
            if (isset($aitem['children'])) {
                $item['leaf'] = false;
                $j = 0;
                foreach ($aitem['children'] as $bitem) {
                    $itemb = array();
                    $arr = array();
                    $itemb['id'] = "{$bitem['id']}";
                    $itemb['old_id'] = "{$bitem['old_indus_id']}";
                    $itemb['text'] = $bitem['name'];
                    $itemb['level'] = 1;
                    $itemb['ptype'] = $item['id'];
                    $itemb['old_ptype'] = $item['old_id'];
                    $itemb['stype'] = $itemb['id'];
                    $itemb['old_stype'] = $itemb['old_id'];
                    $itemb['ptype_name'] = $item['text'];
                    $itemb['stype_name'] = $itemb['text'];
                    $arr = [
                        'ptype' => $itemb['ptype'],
                        'stype' => $itemb['stype'],
                    ];
                    $itemb['checked'] = in_array($arr, $indArr) ? 1 : 0;
                    if (isset($bitem['children'])) {
                        $itemb['leaf'] = false;
                        $item['children'][$j] = $itemb;
                    } else {
                        $itemb['leaf'] = true;
                        $item['children'][$j] = $itemb;
                    }
                    $j++;
                }

            } else {
                $item['leaf'] = true;
                $item['ptype'] = $item['id'];
                $item['stype'] = 0;
                $item['old_ptype'] = $item['old_id'];
                $item['old_stype'] = 0;
                $item['checked'] = in_array($item['id'], ArrayHelper::getColumn($indArr, 'ptype')) ? 1 : 0;
            }
            $cateArr[$i] = $item;
            $i++;
        }
        return json_encode($cateArr);
    }
}

?>