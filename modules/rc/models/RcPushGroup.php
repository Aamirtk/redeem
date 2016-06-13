<?php

namespace app\modules\rc\models;

use Yii;
use \common\api;
use yii\base\Exception;
use yii\data\Pagination;
use yii\base;

/**
 * This is the model class for table "{{%push_position}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $sort
 */
class RcPushGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rc_push_group}}';
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

    //获取列表
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

    //插入数据，如果存在则跳过
    static function _insert_ignore($data)
    {
        if (!$data || !is_array($data))
        {
            throw new CDbException(Yii::t('ext.RDbCommand', 'Columns should be a valid one demention array.'));
        }

        foreach ($data as $key => $val)
        {
            $keys[] = '`' . $key . '`';
            $values[] = "'" . $val . "'";
        }

        $sql = "INSERT IGNORE INTO " . self::tableName() . ' (' . implode(', ', $keys) . ') VALUES (' . implode(
                ', ',
                $values
            ) . ')';

        return Yii::$app->db_maker->createCommand($sql)->execute();
    }

    //插入数据，如果存在则替换
    static function _insert_replace($data)
    {
        if (!$data || !is_array($data))
        {
            throw new CDbException(Yii::t('ext.RDbCommand', 'Columns should be a valid one demention array.'));
        }

        foreach ($data as $key => $val)
        {
            $keys[] = '`' . $key . '`';
            $values[] = "'" . $val . "'";
        }

        $sql = "REPLACE INTO " . self::tableName() . ' (' . implode(', ', $keys) . ') VALUES (' . implode(
                ', ',
                $values
            ) . ')';

        return Yii::$app->db_maker->createCommand($sql)->execute();
    }
}
