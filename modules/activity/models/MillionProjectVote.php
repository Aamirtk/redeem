<?php
namespace frontend\modules\activity\models;

use common\models\CzProject;
use frontend\modules\project\models\Project;
use yii;

/**
 * This is the model class for table "tb_million_project_vote".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $username
 * @property integer $vote_time
 */
class MillionProjectVote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_million_project_vote';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return yii::$app->get('db_cz');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'username', 'vote_time'], 'required'],
            [['vote_time'], 'integer'],
            [['username','project_id'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长id',
            'project_id' => '被投票项目id',
            'username' => '投票人用户名',
            'vote_time' => '投票时间',
        ];
    }

    public function getProject(){
        return $this->hasOne(CzProject::className(),['proj_id'=>'project_id'])->with('studio');
    }
} 