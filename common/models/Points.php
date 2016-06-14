<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use common\models\Goods;

/**
 * This is the model class for table "{{%points}}".
 *
 * @property integer $pid
 * @property string $name
 * @property integer $type
 * @property integer $goods_id
 * @property string $goods_name
 * @property integer $points
 * @property integer $create_at
 * @property integer $update_at
 */
class Points extends \yii\db\ActiveRecord
{
    /**
     * 积分类型
     */
    const POINTS_CONCERN = 1; //关注
    const POINTS_IDAUTH = 2;  //身份认证
    const POINTS_MOBILEAUTH = 3; //手机认证
    const POINTS_SIGNIN = 4; //每日签到
    const POINTS_WECHAT = 5; //分享微信
    const POINTS_PRAISE = 6; //奖励积分

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%points}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'points', 'create_at', 'update_at', ], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['goods_name'], 'string', 'max' => 50],
            [['goods_id'], 'string', 'max' => 40],
            [['create_at' , 'update_at'], 'default', 'value' => time()],
            [['goods_id'], 'validateGoods'],
            [['type'], 'validateType'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'name' => '积分规则名称',
            'type' => '积分类型（1-关注；2-身份认证；3-手机认证；4-每日签到；5-分享微信；6-奖励积分）',
            'goods_id' => '商品编号',
            'goods_name' => '商品名称',
            'points' => '积分数',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 给goods_id字段增加额外条件
     **/
    public function validateGoods($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            //添加的商品必须存在于商品表当中
            $goods = (new Goods)->_get_info(['goods_id' => $this->goods_id]);
            if(!$goods){
                $this->addError($attribute, '商品编号不存在');
            }

        }
    }

    /**
     * 给type字段增加额外条件
     **/
    public function validateType($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            //添加的商品必须存在于商品表当中
            $config = (new PointsConfig())->_get_info(['id' => $this->type]);
            if(!$config){
                $this->addError($attribute, '积分类型不存在');
            }

        }
    }

    /**
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info($where = []) {
        if (empty($where)) {
            return false;
        }

        $obj = self::findOne($where);
        if (!empty($obj)) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list($where = [], $order = 'created_at desc', $page = 1, $limit = 20) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        $_obj->orderBy($order);

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }
        return $_obj->asArray(true)->all();
    }

    /**
     * 获取总条数
     * @param $where array
     * @return int
     */
    public function _get_count($where = []) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else {
            $_obj->where($where);
        }
        return intval($_obj->count());
    }

    /**
     * 添加记录-返回新插入的自增id
     **/
    public static function _add($data) {
        if (!empty($data) && !empty($data['username'])) {
            try {
                $_mdl = new self;

                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                if(!$_mdl->validate()) {//校验数据
                    return false;
                }
                $ret = $_mdl->insert();
                if ($ret !== false) {
                    return self::getDb()->getLastInsertID();
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 保存记录
     * @param $data array
     * @return array|boolean
     */
    public function _save($data) {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                if(!$_mdl->validate()) {//校验数据
                    return false;
                }

                if (!empty($data['id'])) {//修改
                    $id = $data['id'];
                    $ret = $_mdl->updateAll($data, ['id' => $id]);
                } else {//增加
                    $ret = $_mdl->insert();
                }

                if ($ret !== false) {
                    return true;
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 删除记录
     * @param $where array
     * @return array|boolean
     */
    public function _delete($where) {
        if (!empty($where)) {
            try {
                return (new self)->deleteAll($where);
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 获取积分
     * @param $type int
     * @return array|boolean
     */
    public static function _get_points($type) {
        return self::find()->select('points')
            ->where(['type' => $type])
            ->scalar();
    }


}
