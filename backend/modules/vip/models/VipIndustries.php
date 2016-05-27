<?php

namespace backend\modules\vip\models;

use Yii;

/**
 * This is the model class for table "vso_vip_industries".
 *
 * @property integer $id
 * @property string $username
 * @property integer $ptype
 * @property integer $stype
 * @property integer $old_ptype
 * @property integer $old_stype
 * @property integer $create_at
 */
class VipIndustries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_vip_industries';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_uc');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ptype', 'stype', 'old_ptype', 'old_stype', 'create_at'], 'integer'],
            [['username'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户平台注册ID',
            'ptype' => '新行业一级分类',
            'stype' => '新行业二级分类',
            'old_ptype' => '旧行业一级分类',
            'old_stype' => '旧行业二级分类',
            'create_at' => '创建时间',
        ];
    }
}
