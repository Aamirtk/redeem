<?php
namespace frontend\modules\tag\models;

use yii;
use yii\db\ActiveRecord;

/**
 *
 * 推荐位人才标签关联
 * This is the model class for table "tb_tag_recommend_user".
 *
 * @property integer $id
 * @property integer $tag_id
 * @property string $username
 */
class TagRecommendUserModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_tag_recommend_user';
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
            [['tag_id', 'username'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'username' => 'Username',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['username' => 'username']);
    }
}