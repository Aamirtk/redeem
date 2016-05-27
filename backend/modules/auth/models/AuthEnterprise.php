<?php

namespace backend\modules\auth\models;

use Yii;

/**
 * This is the model class for table "{{%auth_enterprise}}".
 *
 * @property integer $enterprise_auth_id
 * @property integer $uid
 * @property string $username
 * @property string $company
 * @property string $licen_num
 * @property string $licen_pic
 * @property double $cash
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $auth_status
 * @property string $legal
 * @property integer $staff_num
 * @property integer $run_years
 * @property string $url
 * @property string $legal_id_card
 * @property string $telephone
 */
class AuthEnterprise extends AuthItem
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_enterprise}}';
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
            [['uid', 'start_time', 'end_time', 'auth_status', 'staff_num', 'run_years'], 'integer'],
            [['cash'], 'number'],
            [['username', 'legal', 'legal_id_card', 'telephone'], 'string', 'max' => 50],
            [['company', 'licen_num'], 'string', 'max' => 100],
            [['licen_pic', 'url'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'enterprise_auth_id' => '企业认证编号',
            'uid' => '用户编号',
            'username' => '用户名',
            'company' => '公司',
            'licen_num' => '营业执照号码',
            'licen_pic' => '营业执照图片',
            'cash' => '支付费用',
            'start_time' => '认证开始时间',
            'end_time' => '认证过期时间',
            'auth_status' => '认证状态（0=>待审核，1=>已通过，2=>未通过）',
            'legal' => '法人代表',
            'staff_num' => '员工人数',
            'run_years' => '经营年数',
            'url' => '公司网址',
            'legal_id_card' => '法人身份证号',
            'telephone' => 'Telephone',
        ];
    }

    /**
     * 获取用户的企业认证状态
     * @param $username 用户名
     * @return int 认证状态
     */
    public function getUserAuthStatus($username)
    {
        if (empty($username))
        {
            return self::STATUS_WAIT;
        }
        $record = self::findOne(['username' => $username, 'auth_code' => self::AUTH_CODE]);
        if (!empty($record))
        {
            return $record->getAttribute('auth_status');
        }
        return self::STATUS_WAIT;
    }

    /**
     * 用户是否通过企业认证
     * @param $username 用户名
     * @return bool（true=>通过，false=>未通过）
     */
    public static function isUserAuthEnterprise($username)
    {
        if (empty($username))
        {
            return false;
        }
        $count = self::find()
            ->where(['username' => $username, 'auth_status' => self::STATUS_PASS])
            ->count('username');
        return $count ? true : false;
    }
}
