<?php

namespace backend\modules\point\services;

use yii;
use yii\base\Component;
use yii\db\ActiveRecord;

use backend\modules\point\models\PointRecord;
use backend\modules\point\models\PointConfigRule;
use backend\modules\point\models\PointChannel;


class PointService  extends ActiveRecord
{


    public function getPointListData($search, $pageSize, $offset)
    {

        $connection = yii::$app->get('db_uc');

        $result = [];
        $countSQL = "SELECT
                    COUNT(*)
                FROM
                    " . PointRecord::tableName() . " AS a
                LEFT JOIN " . PointChannel::tableName() . " AS b ON a.chid = b.chid
                LEFT JOIN " . PointConfigRule::tableName() . " AS c ON a.rid = c.rid";


        $recordsSQL = "SELECT
                    a.rdid,
                    a.username,
                    a.point,
                    a.created_at,
                    b.channelname,
                    c.rulealias
                FROM
                    " . PointRecord::tableName() . " AS a
                LEFT JOIN " . PointChannel::tableName() . " AS b ON a.chid = b.chid
                LEFT JOIN " . PointConfigRule::tableName() . " AS c ON a.rid = c.rid";


        $where = ' where 1 = 1';
        if ($search)
        {
            if (isset($search['rdid']))
            {
                $where .= ' AND a.rdid = ' . $search['rdid'];
            }
            if (isset($search['username']))
            {
                $where .= ' AND a.username = "'.$search['username'].'"';
            }
            if (isset($search['chid']))
            {
                $where .= ' AND a.chid = "'.$search['chid'].'"';
            }
            if (isset($search['rid']))
            {
                $where .= ' AND a.rid = ' . $search['rid'];
            }

            if (isset($search['created_range_start']))
            {
                $where .= ' AND a.created_at  >= ' . strtotime($search['created_range_start']);
            }

            if (isset($search['created_range_end']))
            {
                $where .= ' AND a.created_at  <= ' . strtotime($search['created_range_end']);
            }
        }

        $limit = " order by a.rdid desc  limit {$offset} , {$pageSize}";

        $result['count'] = $connection->createCommand($countSQL . $where)->queryScalar();
        $result['records'] = $connection->createCommand($recordsSQL . $where .$limit)->queryAll();

        return $result;
    }
}