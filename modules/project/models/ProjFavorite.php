<?php

namespace frontend\modules\project\models;

use frontend\modules\talent\models\User;
use Yii;

/**
 * This is the model class for table "{{%proj_favorite}}".
 *
 * @property integer $id
 * @property integer $proj_id
 * @property integer $uid
 * @property string $username
 * @property integer $created_at
 */
class ProjFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%proj_favorite}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_maker');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proj_id', 'username'], 'required'],
            [['proj_id', 'uid', 'created_at'], 'integer'],
            [['username'], 'string', 'max' => 255],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proj_id' => '项目编号',
            'uid' => 'Uid',
            'username' => '粉丝用户名',
            'created_at' => '关注时间',
        ];
    }

    /**
     * 获取项目的关注数量
     * @param $id
     * @return int|string
     */
    public static function getFansNum($id)
    {
        if (empty($id))
        {
            return 0;
        }
        return self::find()
            ->where(['proj_id' => $id])
            ->count();
    }

    /**
     * 修改项目关注数量
     * @param $id 项目编号
     * @return bool 操作结果（true=>成功，false=>失败）
     * @throws \Exception
     */
    public static function updateFansNum($id)
    {
        if (empty($id))
        {
            return false;
        }
        $project = Project::find()->where(['proj_id' => $id])->one();
        if (empty($project))
        {
            return false;
        }
        $project->setAttributes([
            'fans_num' => self::getFansNum($id),
            'updated_at' => time()
        ]);
        if ($project->save())
        {
            return true;
        }
        return false;
    }

    /**
     * 获取当前登录用户关注项目的状态
     * @param $id 项目编号
     * @return bool（true=>已关注，false=>未关注）
     */
    public static function getFavorStatus($id)
    {
        if (empty($id))
        {
            return false;
        }
        $username = User::getLoginedUsername();
        if (empty($username))
        {
            return false;
        }
        $count = self::find()
            ->where(['proj_id' => $id, 'username' => $username])
            ->count();
        return $count ? true : false;
    }
}
