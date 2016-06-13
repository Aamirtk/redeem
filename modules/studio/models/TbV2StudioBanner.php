<?php

namespace frontend\modules\studio\models;

use yii;

/**
 * This is the model class for table "tb_v2_studio_banner".
 *
 * @property integer $id
 * @property integer $s_id
 * @property string $path
 * @property integer $x_axis
 * @property integer $y_axis
 */
class TbV2StudioBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_v2_studio_banner';
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
            [['s_id', 'path'], 'required'],
            [['s_id', 'x_axis', 'y_axis'], 'integer'],
            [['path'], 'string', 'max' => 255]
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
            'path' => '路径',
            'x_axis' => 'x坐标位置',
            'y_axis' => 'y坐标位置',
        ];
    }
}