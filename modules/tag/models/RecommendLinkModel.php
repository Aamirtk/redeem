<?php
namespace frontend\modules\tag\models;

use yii;
use yii\db\ActiveRecord;

/**
 * 推荐广告位
 * This is the model class for table "tb_recommend_link".
 *
 * @property integer $id
 * @property string $comment
 * @property string $img
 * @property string $href
 * @property integer $as_default
 */
class RecommendLinkModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_recommend_link';
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
            [['comment', 'img', 'href'], 'required'],
            [['comment'], 'string', 'max' => 20],
            [['img', 'href'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => '广告位描述',
            'img' => '图片地址',
            'href' => '点击后链接地址',
            'as_default' => '是否为默认广告位'
        ];
    }
}