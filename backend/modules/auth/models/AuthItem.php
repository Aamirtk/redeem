<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "{{%auth_item}}".
 *
 * @property string $auth_code
 * @property string $auth_title
 * @property string $auth_day
 * @property string $auth_small_ico
 * @property string $auth_small_n_ico
 * @property string $auth_big_ico
 * @property string $auth_desc
 * @property double $auth_cash
 * @property integer $auth_expir
 * @property integer $auth_open
 * @property integer $auth_show
 * @property integer $muti_auth
 * @property integer $update_time
 * @property string $auth_dir
 * @property integer $listorder
 * @property string $config
 */
class AuthItem extends \yii\db\ActiveRecord
{
    //认证状态（0=>待审核，1=>已通过，2=>未通过）
    const STATUS_WAIT = 0;
    const STATUS_PASS = 1;
    const STATUS_DENIED = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
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
            [['auth_code'], 'required'],
            [['auth_desc', 'config'], 'string'],
            [['auth_cash'], 'number'],
            [['auth_expir', 'auth_open', 'auth_show', 'muti_auth', 'update_time', 'listorder'], 'integer'],
            [['auth_code', 'auth_dir'], 'string', 'max' => 20],
            [['auth_title', 'auth_day', 'auth_small_ico', 'auth_small_n_ico', 'auth_big_ico'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_code' => '认证项目代码',
            'auth_title' => '认证项目',
            'auth_day' => '认证时间',
            'auth_small_ico' => '认证后小图标',
            'auth_small_n_ico' => '认证前小图标',
            'auth_big_ico' => '认证大图标',
            'auth_desc' => '认证简介',
            'auth_cash' => '认证费用',
            'auth_expir' => '认证有效期',
            'auth_open' => '是否开启认证',
            'auth_show' => '是否显示图标',
            'muti_auth' => '多次认证',
            'update_time' => '更新时间',
            'auth_dir' => '认证目录',
            'listorder' => '排序',
            'config' => '扩展配置',
        ];
    }
}
