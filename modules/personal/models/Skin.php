<?php

namespace frontend\modules\personal\models;

use Yii;

/**
 * This is the model class for table "{{%rc_skin}}".
 *
 * @property integer $id
 * @property string $skin_name
 * @property integer $skin_type
 * @property string $skin_thumb
 */
class Skin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rc_skin}}';
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
            [['skin_type'], 'integer'],
            [['skin_name'], 'string', 'max' => 30],
            [['skin_thumb'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'skin_name' => '皮肤名称',
            'skin_type' => '类型（0-PC端；1-移动端）',
            'skin_thumb' => '缩略图url',
        ];
    }
    /**
     * @获取个人空间皮肤宽度
     * @param $username 平台注册id
     * @return int 宽度
     **/
    public static function getPerIndexWidth($username)
    {
        //取皮肤宽度
        $skin = PersonalSkin::findOne(['username' => trim($username)]);
        $per_skin = $skin ? ['pc_id' => $skin->pc_id, 'mobile_id' => $skin->mobile_id] : ['pc_id' => 1, 'mobile_id' => 2];
        return $per_skin['pc_id'] == 1 ? '360' : '530';
    }
    /**
     * @获取个人空间列表图片宽度
     * @param $username 平台注册id
     * @return int 宽度
     **/
    public static function getPerIndexImgWidth($username)
    {
        //取皮肤宽度
        $skin = PersonalSkin::findOne(['username' => trim($username)]);
        $per_skin = $skin ? ['pc_id' => $skin->pc_id, 'mobile_id' => $skin->mobile_id] : ['pc_id' => 1, 'mobile_id' => 2];
        return $per_skin['pc_id'] == 1 ? '260' : '430';
    }

}
