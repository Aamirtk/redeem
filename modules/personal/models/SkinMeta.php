<?php

namespace frontend\modules\personal\models;

use Yii;

/**
 * This is the model class for table "{{%rc_skin_meta}}".
 *
 * @property integer $meta_id
 * @property integer $skin_id
 * @property string $meta_key
 * @property string $meta_value
 */
class SkinMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rc_skin_meta}}';
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
            [['skin_id'], 'required'],
            [['skin_id'], 'integer'],
            [['meta_key'], 'string', 'max' => 30],
            [['meta_value'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'meta_id' => 'Meta ID',
            'skin_id' => '皮肤ID',
            'meta_key' => '自定义字段名称',
            'meta_value' => '自定义字段值',
        ];
    }

    /**
     * 设置皮肤的扩展字段
     * @inheritdoc
     */
    public static function setSkinMeta($skin_id, $key, $val){
        $meta = new SkinMeta();
        $meta->skin_id = $skin_id;
        $meta->meta_key = $key;
        $meta->meta_value = $val;
        return $meta->save();
    }

    /**
     * 获取皮肤的扩展字段
     * @inheritdoc
     */
    public static function getSkinMeta($skin_id, $key = ''){
        $query = SkinMeta::find();
        return $query->select(['meta_key', 'meta_value'])->where(['skin_id'=>$skin_id])->andFilterWhere(['meta_key'=>$key])->indexBy('meta_key')->all();
    }
}
