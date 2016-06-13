<?php
namespace frontend\modules\tag\models;

use frontend\modules\tag\models\RecommendLinkModel;
use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tb_user".
 *
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property integer $user_type
 * @property integer $status
 * @property string $nickname
 * @property string $truename
 * @property string $avatar
 * @property string $mobile
 * @property string $email
 * @property string $id_card
 * @property integer $qq
 * @property string $tag
 * @property integer $reg_type
 * @property string $reg_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_tim    e
 * @property integer $login_times
 * @property integer $role_id
 * @property string $work_img
 * @property string $work_img_alt
 * @property integer $is_index
 * @property integer $listorder
 * @property integer $extend
 */
class UserModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_user';
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
            [['username', 'nickname', 'created_at'], 'required'],
            [['user_type', 'status', 'qq', 'reg_type', 'created_at', 'updated_at', 'last_login_time', 'login_times', 'role_id', 'is_index', 'listorder', 'extend'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 32],
            [['nickname', 'truename', 'mobile', 'id_card', 'reg_ip'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 255],
            [['email', 'tag', 'work_img', 'work_img_alt'], 'string', 'max' => 100],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'username' => '用户名称',
            'password' => '登录密码',
            'user_type' => '用户类型 1=>个人用户，2=>企业用户,3=>工作室用户 , 6=>校园用户',
            'status' => '用户状态 1=>激活，2=>冻结，3=>删除',
            'nickname' => '昵称',
            'truename' => '真实姓名',
            'avatar' => '头像',
            'mobile' => 'Mobile',
            'email' => '邮箱',
            'id_card' => '身份证号',
            'qq' => 'QQ号',
            'tag' => '用户标签，以 | 分隔的字符串',
            'reg_type' => '用户注册类型 1=>手机注册，2=>邮箱注册，3=>QQ注册，4=>微博注册',
            'reg_ip' => '注册IP',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'last_login_time' => '最后登录时间',
            'login_times' => '登录次数',
            'role_id' => 'Role ID',
            'work_img' => '用户作品图片，暂时字段',
            'work_img_alt' => '首页展示图alt',
            'is_index' => '是否在首页显示 1=>显示， 0=>不显示',
            'listorder' => '排序',
            'extend' => '人才入驻标识符（0=>其他，1=>标准人才，通过实名认证，上传过作品）',
        ];
    }
}