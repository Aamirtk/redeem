<?php

namespace frontend\modules\personal\models;

use Yii;

/**
 * This is the model class for table "{{%rc_personal_skin}}".
 *
 * @property integer $id
 * @property string $username
 * @property integer $pc_id
 * @property integer $mobile_id
 */
class PersonalSkin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rc_personal_skin}}';
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
            [['pc_id', 'mobile_id'], 'integer'],
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
            'username' => '平台用户ID',
            'pc_id' => '个人中心皮肤-PC版',
            'mobile_id' => '个人中心皮肤-移动版',
        ];
    }
}
