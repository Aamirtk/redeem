<?php

namespace backend\modules\trust\services;

use yii;
use yii\db\ActiveRecord;


class TrustService extends ActiveRecord
{

    /***
     * 获得用户评分数据
     *
     * @param $search
     * @param $pageSize
     * @param $offset
     * @return array
     * @throws yii\base\InvalidConfigException
     */
    public function getTrustData($search, $pageSize, $offset)
    {
        $connection = yii::$app->get('db_uc');

        $wdate = date('Ym', time());

        $result = [];
        $countSQL = "SELECT
                        COUNT(*)
                    FROM
                        vso_user_trust_2016 AS a
                    WHERE
                        a.trust_month = '{$wdate}'";


        $dataSQL = "SELECT
                        b.username,
                        b.nickname,
                        a.trust,
                        a.identity_type,
                        a.negative_count
                    FROM
                        vso_user_trust_2016 AS a
                    LEFT JOIN vso_user AS b ON a.username = b.username
                    WHERE
                        a.trust_month = '{$wdate}'";


        $where = ' ';
        if ($search)
        {
            if (isset($search['username']))
            {
                $where .= ' AND a.username = ' . $search['username'];
            }
        }

        $limit = "  limit {$offset} , {$pageSize}";

        $result['count'] = $connection->createCommand($countSQL . $where)->queryScalar();
        $result['trusts'] = $connection->createCommand($dataSQL . $where . $limit)->queryAll();

        return $result;


    }


    /**
     *  获得用户基本信息
     * @param null $username
     * @throws yii\base\InvalidConfigException
     */
    public function getTrustUserInfo($username = null)
    {
        if (empty($username))
        {
            return;
        }

        $connection = yii::$app->get('db_uc');

        $dataSQL = "SELECT
                        b.username,
                        b.create_time,
                        b.truename,
                        a.trust,
                        c.point_level

                    FROM
                        vso_user_trust_2016 AS a
                    LEFT JOIN vso_user AS b ON a.username = b.username
                    LEFT JOIN vso_user_ext AS c ON a.username = c.username
                    WHERE
                        a.username = '{$username}'
                        ORDER BY a.created_at DESC LIMIT 2";

        $result = $connection->createCommand($dataSQL)->queryAll();

        return $result;
    }

}