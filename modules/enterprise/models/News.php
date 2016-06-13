<?php

namespace frontend\modules\enterprise\models;

use common\models\CommonNews;
use frontend\modules\enterprise\models\CrmCompany;
use Yii;

class News extends CommonNews
{
    const OBJ_TYPE = 'crm'; //网站最新动态

    /**
     * 获取列表 rj
     * */
    public static function getList($where = [], $order = [], $offset = 0, $limit = 10)
    {
        return self::find()
            ->where($where)
            ->orderBy($order)
            ->offset($offset)
            ->limit($limit)
            ->asArray(true)
            ->all();
    }

    /**
     * 获取单个文件 rj
     * */
    public static function getInfo($where = [], $order = [], $andwhere = [])
    {
        if (empty($where)){
            return false;
        }

        $obj = self::find()->where($where)->andWhere($andwhere)->orderBy($order)->one();
        if (!empty($obj)){
            return $obj->toArray();
        }
    }

    /**
     * 获取obj_id
     * */
    public static function getUsernameByObjId($id)
    {
        if (empty($id)){
            return false;
        }
        $obj = self::findOne(['id' => intval($id)]);
        if(empty($obj['obj_id'])){
            return false;
        }
        $crm = CrmCompany::findOne(['id' => $obj['obj_id']]);
        if(empty($crm['username'])){
            return false;
        }
        return $crm['username'];
    }


}
