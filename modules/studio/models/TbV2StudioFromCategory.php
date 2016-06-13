<?php
namespace frontend\modules\studio\models;

use yii;

/**
 * This is the model class for table "tb_v2_studio_from_category".
 *
 * @property integer $id
 * @property integer $s_id
 * @property integer $c_id
 */
class TbV2StudioFromCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_v2_studio_from_category';
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
            [['s_id', 'c_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            's_id' => '工作室编号',
            'c_id' => '行业分类编号',
        ];
    }

    public function getCat(){
        return $this->hasOne(TbV2StudioCategory::className(),['c_id'=>'c_id']);
    }
} 