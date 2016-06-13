<?php
namespace frontend\modules\tag\models;

use frontend\modules\tag\models\TagRecommendLinkModel;
use frontend\modules\tag\models\TagRecommendUserModel;
use yii;
use yii\db\ActiveRecord;

/**
 * 标签同义词
 * This is the model class for table "tb_tag_synonyms".
 *
 * @property integer $id
 * @property string $keyword
 * @property string $synonyms
 * @property integer $hot
 */
class SynonymsModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_tag_synonyms';
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
            [['keyword'], 'required'],
            [['hot'], 'integer'],
            [['keyword'], 'string', 'max' => 20],
            [['synonyms'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长id',
            'keyword' => '关键字',
            'synonyms' => '关键字近义词',
            'hot' => '关键字搜索热度',
        ];
    }

    public function getLink()
    {
        return $this->hasMany(TagRecommendLinkModel::className(), ['tag_id' => 'id'])->with('link');
    }

    public function getUser()
    {
        return $this->hasMany(TagRecommendUserModel::className(), ['tag_id' => 'id'])->with('user');
    }
}