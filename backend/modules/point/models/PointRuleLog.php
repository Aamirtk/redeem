<?php

namespace backend\modules\point\models;

use Yii;

/**
 * This is the model class for table "vso_point_rule_log".
 *
 * @property integer $clid
 * @property integer $uid
 * @property string $username
 * @property integer $obj_id
 * @property string $obj_type
 * @property integer $rid
 * @property integer $chid
 * @property integer $total
 * @property integer $cyclenum
 * @property integer $point
 * @property integer $created_at
 * @property integer $updated_at
 */
class PointRuleLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_point_rule_log';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_uc');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'obj_id', 'rid', 'chid', 'total', 'cyclenum', 'point', 'created_at', 'updated_at'], 'integer'],
            [['obj_id', 'obj_type'], 'required'],
            [['username'], 'string', 'max' => 30],
            [['obj_type'], 'string', 'max' => 64],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'clid' => '策略日志ID',
            'uid' => '用户ID',
            'username' => '用户名',
            'obj_id' => '对象ID',
            'obj_type' => '对象类型',
            'rid' => '规则ID',
            'chid' => '频道ID',
            'total' => '被执行总次数',
            'cyclenum' => '周期被执行次数',
            'point' => '积分值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
