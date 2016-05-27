<?php

namespace backend\modules\opportunity\models;

use backend\modules\task\models\Task;
use Yii;

/**
 * This is the model class for table "vso_opportunity_task".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $task_wid
 * @property integer $recommend_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class OpportunityTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_opportunity_task';
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
            [['task_id', 'recommend_count', 'created_at', 'updated_at'], 'integer'],
            [['task_wid'], 'string', 'max' => 13],
            [['task_id'], 'unique'],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '任务推送ID',
            'task_id' => '任务编号',
            'task_wid' => '新版task_id，时间戳加三位随机数',
            'recommend_count' => '推送会员数量次数',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取任务信息，用于查询时表连接
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['task_id' => 'task_id']);
    }
}
