<?php

namespace app\modules\rc\models;

use Yii;
use \common\api;
use yii\base;

/**
 * This is the model class for table "{{%push_position}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $sort
 */
class RcPushInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rc_push_info}}';
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
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    }

    //获取分类列表
    static function _get_list($where = [], $order = '')
    {
        return self::find()->where($where)->orderBy($order)->asArray(true)->all();
    }

    //获取详情
    public static function _get_info($where = [])
    {
        if (empty($where)):
            return false;
        endif;

        $obj = self::findOne($where);
        if (!empty($obj)):
            return $obj->toArray();
        endif;
        return false;
    }
}
