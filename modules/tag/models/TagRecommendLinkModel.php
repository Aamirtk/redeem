<?php
namespace frontend\modules\tag\models;

use frontend\modules\tag\models\RecommendLinkModel;
use yii;
use yii\db\ActiveRecord;

/**
 * 推荐位标签关联
 *
 * This is the model class for table "tb_tag_recommend_link".
 *
 * @property integer $id
 * @property integer $tag_id
 * @property integer $link_id
 */
class TagRecommendLinkModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_tag_recommend_link';
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
            [['tag_id', 'link_id'], 'required'],
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
            'link_id' => 'Link ID',
        ];
    }

    public function getLink()
    {
        return $this->hasOne(RecommendLinkModel::className(), ['id' => 'link_id']);
    }
}