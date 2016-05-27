<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%space}}".
 *
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property string $sec_code
 * @property string $email
 * @property string $user_pic
 * @property integer $group_id
 * @property integer $isvip
 * @property integer $status
 * @property integer $user_type
 * @property string $sex
 * @property string $marry
 * @property string $hometown
 * @property string $residency
 * @property string $address
 * @property string $birthday
 * @property string $truename
 * @property string $idcard
 * @property string $idpic
 * @property string $qq
 * @property string $msn
 * @property string $fax
 * @property string $phone
 * @property string $mobile
 * @property integer $indus_id
 * @property integer $indus_pid
 * @property string $skill_ids
 * @property string $summary
 * @property string $experience
 * @property integer $reg_time
 * @property string $reg_ip
 * @property string $domain
 * @property integer $credit
 * @property string $balance
 * @property integer $balance_status
 * @property integer $pub_num
 * @property integer $take_num
 * @property integer $nominate_num
 * @property integer $accepted_num
 * @property integer $vip_start_time
 * @property integer $vip_end_time
 * @property string $pay_zfb
 * @property string $pay_cft
 * @property string $pay_bank
 * @property integer $score
 * @property integer $buyer_credit
 * @property integer $buyer_good_num
 * @property string $buyer_level
 * @property integer $buyer_total_num
 * @property integer $seller_credit
 * @property integer $seller_good_num
 * @property string $seller_level
 * @property integer $seller_total_num
 * @property integer $studio_id
 * @property integer $last_login_time
 * @property string $point
 * @property string $user_path
 * @property integer $views
 * @property string $nickname
 * @property string $game_star_desc
 * @property string $real_name
 * @property integer $goldenfarm_level
 * @property integer $spread_num
 * @property integer $university
 * @property integer $focus_num
 * @property integer $goldenfarm_start
 * @property integer $goldenfarm_end
 * @property integer $auth_bank
 * @property integer $auth_email
 * @property integer $auth_enterprise
 * @property integer $auth_mobile
 * @property integer $auth_realname
 * @property integer $auth_university
 * @property string $contact
 * @property integer $pre_type
 * @property integer $auth_design
 * @property integer $entscale
 * @property string $sitedomain
 * @property integer $extended
 */
class KekeWitkeySpace extends \yii\db\ActiveRecord
{
    const USER_INACTIVE = 2;        // 未激活
    const USER_ACTIVE = 1;          // 已经激活
    const SEX_FEMALE = '女';           // 女性
    const SEX_MALE = '男';             // 男性
    const SEX_CONFIDENTIAL = '保密';     // 保密

    const USER_TYPE_PERSON = 1;         // 个人用户
    const USER_TYPE_ENTERPRISE = 2;     // 企业用户
    const USER_TYPE_UNIVERSITY = 6;     // 校园用户

    const BASIC_INFO_KEY_NUMBER = 10;   // 用户基本信息中字段数
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%space}}';
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
            [['username'], 'required'],
            [['group_id', 'isvip', 'status', 'user_type', 'indus_id', 'indus_pid', 'reg_time', 'credit', 'balance_status', 'pub_num', 'take_num', 'nominate_num', 'accepted_num', 'vip_start_time', 'vip_end_time', 'score', 'buyer_credit', 'buyer_good_num', 'buyer_total_num', 'seller_credit', 'seller_good_num', 'seller_total_num', 'studio_id', 'last_login_time', 'views', 'goldenfarm_level', 'spread_num', 'university', 'focus_num', 'goldenfarm_start', 'goldenfarm_end', 'auth_bank', 'auth_email', 'auth_enterprise', 'auth_mobile', 'auth_realname', 'auth_university', 'pre_type', 'auth_design', 'entscale', 'extended'], 'integer'],
            [['summary', 'experience', 'pay_bank', 'buyer_level', 'seller_level', 'game_star_desc'], 'string'],
            [['balance'], 'number'],
            [['username', 'password', 'sec_code', 'email', 'msn', 'domain'], 'string', 'max' => 50],
            [['user_pic', 'idpic', 'pay_zfb', 'pay_cft'], 'string', 'max' => 100],
            [['sex', 'marry', 'hometown', 'birthday', 'real_name'], 'string', 'max' => 10],
            [['residency', 'contact'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 200],
            [['truename', 'idcard', 'qq', 'fax', 'phone', 'mobile', 'reg_ip', 'point'], 'string', 'max' => 20],
            [['skill_ids'], 'string', 'max' => 150],
            [['user_path', 'nickname'], 'string', 'max' => 255],
            [['sitedomain'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'username' => '用户名',
            'password' => '用户密码',
            'sec_code' => '安全码',
            'email' => '邮箱',
            'user_pic' => '用户头像',
            'group_id' => '用户组编号',
            'isvip' => '是否是VIP',
            'status' => '用户状态',
            'user_type' => '用户类型（1=>普通用户；2=>企业认证用户；6=>校园认证用户）',
            'sex' => '性别',
            'marry' => '是否已婚',
            'hometown' => '出生地',
            'residency' => '所在地',
            'address' => '详细地址',
            'birthday' => '出生日期',
            'truename' => '真实姓名',
            'idcard' => '身份证号',
            'idpic' => '身份证复印件',
            'qq' => 'QQ',
            'msn' => 'MSN',
            'fax' => '传真',
            'phone' => '电话',
            'mobile' => '手机',
            'indus_id' => '所属行业编号',
            'indus_pid' => '所属行业父编号',
            'skill_ids' => '技能编号',
            'summary' => '简介',
            'experience' => '经历',
            'reg_time' => '注册时间',
            'reg_ip' => '注册IP',
            'domain' => '域名',
            'credit' => '创意币',
            'balance' => '账号余额',
            'balance_status' => '余额状态',
            'pub_num' => '发布数',
            'take_num' => '承接数',
            'nominate_num' => 'Nominate Num',
            'accepted_num' => '接受数目',
            'vip_start_time' => 'VIP开始时间',
            'vip_end_time' => 'VIP结束时间',
            'pay_zfb' => '支付宝',
            'pay_cft' => '财付通',
            'pay_bank' => '银行',
            'score' => '积分',
            'buyer_credit' => '买家信誉',
            'buyer_good_num' => '买家好评数',
            'buyer_level' => '买家等级',
            'buyer_total_num' => '买家购买总数',
            'seller_credit' => '卖家信誉',
            'seller_good_num' => '卖家好评数',
            'seller_level' => '卖家等级',
            'seller_total_num' => '卖家出售总数',
            'studio_id' => '工作室编号',
            'last_login_time' => '最后登录时间',
            'point' => '坐标',
            'user_path' => 'User Path',
            'views' => '浏览次数',
            'nickname' => '昵称',
            'game_star_desc' => 'Game Star Desc',
            'real_name' => 'Real Name',
            'goldenfarm_level' => 'Goldenfarm Level',
            'spread_num' => '推广码',
            'university' => 'University',
            'focus_num' => '人才被关注或收藏的次数',
            'goldenfarm_start' => '后台手动改VIP等级，生效开始时间',
            'goldenfarm_end' => '后台手动改VIP等级，生效结束时间',
            'auth_bank' => 'Auth Bank',
            'auth_email' => 'Auth Email',
            'auth_enterprise' => 'Auth Enterprise',
            'auth_mobile' => 'Auth Mobile',
            'auth_realname' => 'Auth Realname',
            'auth_university' => 'Auth University',
            'contact' => '联系方式：可以是手机（11位） 也可以是电话号码（1111-2222222）',
            'pre_type' => '注册前预先确定的用户类型 (不一定认证) 1:个人用户 2:企业用户',
            'auth_design' => 'Auth Design',
            'entscale' => 'Entscale',
            'sitedomain' => '二级域名标示位',
            'extended' => 'Extended',
        ];
    }

    /**
     * 获取用户在keke数据库中的ID
     * @param $username
     * @return integer
     */
    public static function getUidByUsername($username)
    {
        if (empty($username))
        {
            return '';
        }
        $uid = self::find()
            ->select('uid')
            ->where(['username' => $username])
            ->scalar();
        return $uid ? $uid : '';
    }

    /**
     * 获取用户基本信息
     * 字段范围：昵称，性别，出生日期，职业，手机号，邮箱，QQ，所属地区，详细地址，人才标签
     * @param $username
     * @return array
     */
    public static function getUserBasicInfo($username)
    {
        if (empty($username))
        {
            return [];
        }
        $info = self::find()
            ->select('nickname, sex, birthday, indus_pid, mobile, email, qq, residency, address')
            ->where(['username' => $username])
            ->asArray()
            ->one();
        if (empty($info))
        {
            return [];
        }
        $info['lable'] = KekeWitkeyLableSpace::getUserLableStrByUsername($username);
        return $info;
    }

    /**
     * 获取用户基本信息的统计数据
     * 包括：用户基本信息中所有字段数与有效字段数
     * @param string $username 用户名
     * @return array
     */
    public static function getUserBasicInfoStatistic($username)
    {
        $info = self::getUserBasicInfo($username);
        if (empty($info))
        {
            return [
                'key_length' => self::BASIC_INFO_KEY_NUMBER,
                'value_length' => 0
            ];
        }
        // 统计用户基本信息中所有字段数与有效字段数
        $data = [
            'key_length' => count(array_keys($info)),
            'value_length' => count(array_filter(array_values($info)))
        ];
        return $data;
    }
}
