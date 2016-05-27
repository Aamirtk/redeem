<?php

namespace backend\modules\industry\models;

use Yii;

/**
 * This is the model class for table "{{%industry}}".
 *
 * @property integer $indus_id
 * @property integer $indus_pid
 * @property string $indus_name
 * @property string $indus_name_two_short
 * @property string $indus_name_four_short
 * @property integer $is_recommend
 * @property integer $indus_type
 * @property integer $listorder
 * @property integer $on_time
 * @property string $list_type
 * @property string $list_tpl
 * @property string $indus_intro
 * @property string $list_desc
 * @property integer $is_game
 */
class KekeWitkeyIndustry extends \yii\db\ActiveRecord
{
    const REDIS_KEY_PREFIX = 'indus_name_';    // 行业缓存redis时key前缀

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%industry}}';
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
            [['indus_pid', 'is_recommend', 'indus_type', 'listorder', 'on_time', 'is_game'], 'integer'],
            [['list_desc'], 'string'],
            [['indus_name'], 'string', 'max' => 100],
            [['indus_name_two_short'], 'string', 'max' => 2],
            [['indus_name_four_short'], 'string', 'max' => 4],
            [['list_type', 'list_tpl'], 'string', 'max' => 20],
            [['indus_intro'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'indus_id' => 'Indus ID',
            'indus_pid' => 'Indus Pid',
            'indus_name' => 'Indus Name',
            'indus_name_two_short' => '行业名二字简称',
            'indus_name_four_short' => '行业名四字简称',
            'is_recommend' => 'Is Recommend',
            'indus_type' => 'Indus Type',
            'listorder' => 'Listorder',
            'on_time' => 'On Time',
            'list_type' => 'List Type',
            'list_tpl' => 'List Tpl',
            'indus_intro' => 'Indus Intro',
            'list_desc' => 'List Desc',
            'is_game' => 'Is Game',
        ];
    }

    /**
     * 根据行业编号获取行业名称
     * 使用redis缓存
     * @param integer $indusId 行业编号
     * @return string 行业名称
     */
    public static function getIndusNameById($indusId)
    {
        if (empty($indusId))
        {
            return '';
        }

        // 行业名称在redis中缓存的key
        $key = self::REDIS_KEY_PREFIX . $indusId;
        $indus_name = yii::$app->redis->GET($indusId);
        if (!$indus_name)
        {
            $expire_time = yii::$app->params['redis_expire_time_month'];
            $indus_name = self::find()
                ->select('indus_name')
                ->where(['indus_id' => $indusId])
                ->scalar();
            yii::$app->redis->SETEX($key, $expire_time, $indus_name);
        }
        return empty($indus_name) ? '' : $indus_name;
    }
}
