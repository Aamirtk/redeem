<?php

namespace frontend\modules\talent\models;

use common\models\CommonTalent;
use Yii;

class User extends CommonTalent
{
    /**
     * 获取推荐用户，用于首页
     * @param $user_type
     * @param int $limit
     * @return array|static
     */
    public static function getRecomUser($user_type, $limit=5)
    {
        $typeArr = [
            self::USER_TYPE_PERSON,
            self::USER_TYPE_ENTERPRISE
        ];
        if (!in_array($user_type, $typeArr))
        {
            return [];
        }

        if ($user_type == self::USER_TYPE_ENTERPRISE)
        {
            $where = ['user_type' => self::USER_TYPE_ENTERPRISE];
        }
        else
        {
            $where = ['<>', 'user_type', self::USER_TYPE_ENTERPRISE];
        }
        $list = User::find()
            ->where(['is_index' => 1])
            ->andWhere($where)
            ->orderBy(['listorder' => SORT_ASC])
            ->limit($limit)
            ->all();

        return empty($list) ? []: $list;
    }
}
