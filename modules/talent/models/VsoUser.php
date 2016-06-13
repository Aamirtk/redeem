<?php

namespace frontend\modules\talent\models;

use common\api\VsoApi;
use Yii;

/**
 * This is the model class for table "vso_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $nickname
 * @property string $truename
 * @property string $realname
 * @property string $avatar
 * @property string $email
 * @property integer $sex
 * @property integer $birthday
 * @property string $mobile
 * @property string $qq
 * @property integer $indus_id
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $district
 * @property integer $status
 * @property string $description
 * @property string $security_pwd
 * @property integer $chg_pwd
 * @property integer $update_time
 * @property integer $create_time
 * @property integer $user_type
 * @property string $s_password
 * @property integer $dim_status
 * @property integer $ftp_status
 * @property integer $university
 * @property string $spread_num
 * @property string $reg_type
 * @property string $sec_code
 * @property integer $isnewpwd
 * @property integer $goldenfarm_level
 * @property integer $extended
 * @property string $contact
 * @property integer $pre_type
 * @property integer $logined
 * @property string $sitedomain
 * @property integer $entscale
 */
class VsoUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_user';
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
            [['username', 'password', 'update_time', 'create_time', 'user_type', 's_password'], 'required'],
            [['sex', 'birthday', 'indus_id', 'status', 'chg_pwd', 'update_time', 'create_time', 'user_type', 'dim_status', 'ftp_status', 'university', 'isnewpwd', 'goldenfarm_level', 'extended', 'pre_type', 'logined', 'entscale'], 'integer'],
            [['description'], 'string'],
            [['username', 'mobile', 'qq', 'country', 'province', 'city', 'district', 'contact'], 'string', 'max' => 30],
            [['password', 'nickname', 'realname', 'security_pwd'], 'string', 'max' => 40],
            [['truename', 'spread_num'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 200],
            [['email', 's_password'], 'string', 'max' => 100],
            [['reg_type', 'sec_code'], 'string', 'max' => 50],
            [['sitedomain'], 'string', 'max' => 5],
            [['username'], 'unique'],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'nickname' => 'Nickname',
            'truename' => 'Truename',
            'realname' => 'Realname',
            'avatar' => 'Avatar',
            'email' => 'Email',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'mobile' => 'Mobile',
            'qq' => 'Qq',
            'indus_id' => 'Indus ID',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'status' => '1:已激活 2:未激活',
            'description' => 'Description',
            'security_pwd' => 'Security Pwd',
            'chg_pwd' => '0:changed 1:unchange(old password hash)',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
            'user_type' => 'User Type',
            's_password' => '不变的ldap密码保存字段，加密',
            'dim_status' => 'dim注册状态 0：成功 1：代表还在处理中',
            'ftp_status' => 'FTP允许状态 0：代表可以用 1：代表禁止了FTP',
            'university' => '状态 0：普通1：学生',
            'spread_num' => 'Spread Num',
            'reg_type' => '注册类型',
            'sec_code' => '安全码',
            'isnewpwd' => '判断用户的密码是否为新密码，开始使用时需要用户重置，1是不需要重置 2需要重置',
            'goldenfarm_level' => '渲染等级',
            'extended' => 'Extended',
            'contact' => '联系方式：可以是手机（11位） 也可以是电话号码（1111-2222222）',
            'pre_type' => '注册前预先确定的用户类型 (不一定认证) 1:个人用户 2:企业用户',
            'logined' => '是否登录过（0=>否，1=>是）',
            'sitedomain' => '域名，记录用户注册来源。',
            'entscale' => 'Entscale',
        ];
    }

    /**
     * 手机号是否已经注册
     * 已注册，用户入驻
     * 未注册，注册新用户，用户入驻
     * @param $mobile 手机号
     * @return array
     * result bool（true=>入驻成功，false=>入驻失败）
     * username string 入驻用户的用户名
     */
    public static function isUserRegisted($mobile)
    {
        if (empty($mobile))
        {
            return ['result' => false];
        }
        $userInfo = self::findOne(['mobile' => $mobile, 'logined' => 1]);
        $username = '';
        // 该手机号未注册，通过接口中心注册
        if (empty($userInfo))
        {
            // 注册新用户
            $url = yii::$app->params['apiRegisterMobileUrl'];
            //pgu 2016.03.15添加,百万大赛手机版入驻入口,用户注册自动关联上线到30189049,匡昊账号
            $result = VsoApi::send($url, ['mobile' => $mobile,'prom_username'=>'30189049']);
            // 注册成功，获取用户名
            if(isset($result['ret']) && $result['ret'] == 13760)
            {
                $userInfo = isset($result['data']) && !empty($result['data']) ? $result['data'] : [];
                $username = isset($userInfo['username']) && !empty($userInfo['username']) ? $userInfo['username'] : '';
            }
        }
        else
        {
            $username = $userInfo['username'];
        }
        // 用户入驻创客空间
        $result = User::createUser($username);
        return ['result' => $result, 'username' => $username];
    }
}
