<?php
namespace frontend\modules\studio\models;

use yii;

/**
 * This is the model class for table "tb_v2_studio_category".
 *
 * @property integer $c_id
 * @property string $name
 * @property integer $f_id
 * @property string $status
 * @property integer $sort
 * @property string $is_default
 */
class TbV2StudioCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_v2_studio_category';
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
            [['name'], 'required'],
            [['f_id', 'sort'], 'integer'],
            [['status', 'is_default'], 'string'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'c_id' => '分类ID',
            'name' => '分类名称',
            'f_id' => '父级ID',
            'status' => '是否启用',
            'sort' => '排序（由大到小）',
            'is_default' => '是否默认，1=是',
        ];
    }
} 