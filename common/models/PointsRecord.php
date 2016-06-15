<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%points_record}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $point_id
 * @property integer $points
 * @property string $points_name
 * @property integer $create_at
 */
class PointsRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%points_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'point_id', 'points', 'create_at'], 'integer'],
            [['points_name'], 'string', 'max' => 50],
            [['create_at'], 'default', 'value' => time()],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => '积分赠送记录ID',
            'uid' => '用户ID',
            'point_id' => '赠送积分ID',
            'points' => '赠送积分数',
            'points_name' => '积分赠送名称',
            'create_at' => '创建时间',
        ];
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
}
