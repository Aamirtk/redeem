<?php

namespace backend\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task_file}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $username
 * @property integer $task_id
 * @property string $task_title
 * @property integer $comment_id
 * @property integer $on_time
 * @property string $modify_name
 * @property integer $modify_time
 * @property string $complete_status
 * @property integer $modify_id
 */
class TaskFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_file}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_keke');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'task_id', 'comment_id', 'on_time', 'modify_time', 'modify_id'], 'integer'],
            [['username', 'modify_name'], 'string', 'max' => 50],
            [['task_title', 'complete_status'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'task_id' => 'Task ID',
            'task_title' => 'Task Title',
            'comment_id' => 'Comment ID',
            'on_time' => 'On Time',
            'modify_name' => '上次修改人名称',
            'modify_time' => '最后修改时间',
            'complete_status' => '任务完成状态',
            'modify_id' => '上次修改人id',
        ];
    }
}
