<?php
namespace frontend\modules\studio\models;

use yii;

/**
 * This is the model class for table "tb_v2_studio_trends_favorite".
 *
 * @property integer $id
 * @property string $username
 * @property integer $trends_id
 */
class TbV2StudioTrendsFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_v2_studio_trends_favorite';
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
            [['username', 'trends_id'], 'required'],
            [['trends_id'], 'integer'],
            [['username'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长id',
            'username' => '点赞人',
            'trends_id' => '被点赞工作室动态id',
        ];
    }
} 