<?php

namespace frontend\modules\talent\models;

use Yii;

/**
 * This is the model class for table "{{%lable_space}}".
 *
 * @property integer $service_id
 * @property string $lable_name
 * @property string $lable_encrypt
 */
class KekeWitkeyLableSpace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lable_space}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_keke');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id'], 'required'],
            [['service_id'], 'integer'],
            [['lable_name', 'lable_encrypt'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'lable_name' => 'Lable Name',
            'lable_encrypt' => 'Lable Encrypt',
        ];
    }

    /**
     * 获取用户标签字符串
     * @param $username 用户名
     * @return string 逗号分隔的标签字符串，最多5个标签（标签1，标签2，标签3，标签4，标签5）
     */
    public static function getUserKekeTag($username)
    {
        if (empty($username))
        {
            return '';
        }
        $uid = KekeWitkeySpace::getUidByUsername($username);
        $lable = self::find()
            ->select('lable_name')
            ->where(['service_id' => $uid])
            ->scalar();
        return empty($lable) ? '' : $lable;
    }
}
