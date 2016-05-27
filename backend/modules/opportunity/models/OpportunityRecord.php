<?php

namespace backend\modules\opportunity\models;

use Yii;

/**
 * This is the model class for table "vso_opportunity_record".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $task_wid
 * @property string $task_title
 * @property string $task_desc
 * @property string $username
 * @property integer $view_status
 * @property integer $view_time
 * @property integer $contact_status
 * @property integer $contact_time
 * @property integer $indus_id
 * @property integer $indus_pid
 * @property string $indus_name
 * @property integer $created_at
 * @property integer $updated_at
 */
class OpportunityRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_opportunity_record';
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
            [['task_id', 'view_status', 'view_time', 'contact_status', 'contact_time', 'indus_id', 'indus_pid', 'created_at', 'updated_at'], 'integer'],
            [['task_wid'], 'string', 'max' => 13],
            [['task_title'], 'string', 'max' => 100],
            [['task_desc'], 'string', 'max' => 2000],
            [['username'], 'string', 'max' => 50],
            [['indus_name'], 'string', 'max' => 255],
            [['task_id', 'username'], 'unique', 'targetAttribute' => ['task_id', 'username'], 'message' => '任务编号和用户名的组合已经存在。'],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '推送ID',
            'task_id' => '任务编号',
            'task_wid' => '新版task_id，时间戳加三位随机数',
            'task_title' => '任务标题',
            'task_desc' => '任务摘要',
            'username' => '用户名',
            'view_status' => '查看状态 0：未查看 1：已查看',
            'view_time' => '查看时间',
            'contact_status' => '联系状态 0：未联系 1：已联系',
            'contact_time' => '查看时间',
            'indus_id' => '行业编号',
            'indus_pid' => '父行业编号',
            'indus_name' => '任务行业',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
