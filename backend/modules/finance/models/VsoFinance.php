<?php

namespace backend\modules\finance\models;

use Yii;

/**
 * This is the model class for table "vso_finance".
 *
 * @property integer $fina_id
 * @property string $fina_type
 * @property string $fina_action
 * @property integer $order_id
 * @property integer $uid
 * @property string $username
 * @property string $obj_type
 * @property string $obj_id
 * @property string $fina_cash
 * @property string $user_balance
 * @property string $fina_credit
 * @property string $user_credit
 * @property string $fina_source
 * @property integer $fina_time
 * @property string $recharge_cash
 * @property string $site_profit
 * @property string $unique_num
 * @property integer $is_trust
 * @property string $trust_type
 * @property string $fina_mem
 * @property integer $radio
 * @property integer $balance_fina_id
 * @property integer $prom_status
 * @property string $ip
 * @property string $account_from
 * @property string $account_to
 * @property integer $extend
 * @property string $fina_wid
 */
class VsoFinance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_finance';
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
            [['order_id', 'uid', 'fina_time', 'is_trust', 'radio', 'balance_fina_id', 'prom_status', 'extend'], 'integer'],
            [['fina_cash', 'user_balance', 'fina_credit', 'user_credit', 'recharge_cash', 'site_profit'], 'number'],
            [['fina_mem'], 'string'],
            [['fina_type', 'unique_num'], 'string', 'max' => 10],
            [['fina_action', 'fina_source', 'trust_type', 'ip'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 50],
            [['obj_type', 'obj_id'], 'string', 'max' => 64],
            [['account_from', 'account_to', 'fina_wid'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fina_id' => 'Fina ID',
            'fina_type' => '入账或出账',
            'fina_action' => '财务业务类型',
            'order_id' => '财务订单号',
            'uid' => '用户id',
            'username' => '用户名',
            'obj_type' => '目标类型',
            'obj_id' => '对象ID',
            'fina_cash' => '人民币金额',
            'user_balance' => '用户人民币余额',
            'fina_credit' => '创意币金额',
            'user_credit' => '用户创意币余额',
            'fina_source' => 'Fina Source',
            'fina_time' => '财务记录时间',
            'recharge_cash' => 'Recharge Cash',
            'site_profit' => 'Site Profit',
            'unique_num' => 'Unique Num',
            'is_trust' => 'Is Trust',
            'trust_type' => 'Trust Type',
            'fina_mem' => '财务备注信息',
            'radio' => 'Radio',
            'balance_fina_id' => 'Balance Fina ID',
            'prom_status' => 'Prom Status',
            'ip' => 'IP地址',
            'account_from' => '财务来源',
            'account_to' => '财务去向',
            'extend' => 'Extend',
            'fina_wid' => 'Fina Wid',
        ];
    }
}
