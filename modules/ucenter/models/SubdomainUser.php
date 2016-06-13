<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/05/09
 * Time: 17:00
 */
namespace frontend\modules\ucenter\models;

use Yii;
use common\api\VsoApi;
use yii\base\Exception;
use frontend\modules\personal\models\Person;

/**
 * This is the model class for table "{{%subdomain_user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $subdomain
 * @property integer $created_at
 */
class SubdomainUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subdomain_user}}';
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
            [['created_at'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['subdomain'], 'string', 'max' => 15],
            [['created_at'], 'default', 'value' => time()],
            [['username'], 'unique', 'message' => '您只能设置一个域名！'],
            [['subdomain'], 'unique', 'message' => '您设置的域名已经被占用，请重新设置！'],
            [['subdomain'], 'validateDomain'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户平台注册ID',
            'subdomain' => '用户自定义二级域名',
            'created_at' => '创建时间',
        ];
    }

    /**
     * 验证平台注册ID,需要满足条件
    1)不能是别人的平台注册账号（username）
    2)不能是别人已经占用了的二级域名（或者正在审核中的）
    3)不能是保留的二级域名（由后台设置）
    4)不能是非法二级域名（由后台设置）
    5)域名只能包含数字、小写字母、-，必须包含字母，必须以英文小写字母开头，不能以-字符结尾，不能是render,ftp,udp后面加数字
    6)构成域名的字符数应该大于等于6，小于等于15
     **/
    public function validateDomain($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            //未做更改
            if($this->username == $this->subdomain){
                $this->addError($attribute, '您未更改您的域名，请请重新设置！');
            }

            //构成域名的字符数应该大于等于6，小于等于15
            $len = strlen($this->subdomain);
            if($len < 6 || $len > 15){
                $this->addError($attribute, '您设置的域名必须为6-15个字符！');
            }

            //域名只能包含数字、小写字母、-，必须包含字母，必须以英文小写字母开头，不能以-字符结尾
            $pattern = "/^(?=.*[a-z])([a-z][0-9a-z-]+)(?<!-)$/";
            if(!preg_match($pattern, $this->subdomain)){
                $this->addError($attribute, '您设置的域名只能包含“小写字母”，“数字”，“-”，必须以“小写字母”开头，不能以“-”结尾！');
            }

            //不能是render,ftp,udp后面加数字
            $pattern = "/^(?:(ftp|render|udp)\\d*)$/";
            if(preg_match($pattern, $this->subdomain)){
                $this->addError($attribute, '您设置的域名不符合平台规范，请重新设置！');
            }

            // 不能是别人的平台注册账号（username）
            $res = VsoApi::send(yiiParams('checkUserDomainUrl'), ['username' => $this->subdomain], 'get');
            if(!isset($res['data']['res']) || !$res['data']['res']){
                $this->addError($attribute, '您设置的域名已经被占用，请重新设置！');
            }

            // 不能是保留或者非法的的二级域名
            $mdl_dm = new Subdomain();
            $has_subdomain = $mdl_dm->_get_info([
                'subdomain' => $this->subdomain,
                'is_deleted' => $mdl_dm::NO_DELETE,
            ]);
            if($has_subdomain){
                $this->addError($attribute, '您设置的域名不符合平台规范，请重新设置！');
            }

            //如果别人申请了，正在审核中，那也不能申请
            $mdl_ch = new SubdomainCheck();
            $check = $mdl_ch->_get_info([
                'subdomain' => $this->subdomain,
                'check_status' => [$mdl_ch::CHECK_WAIT, $mdl_ch::CHECK_PASS]
            ]);
            if(!empty($check) && $check['username'] != $this->username){
                $this->addError($attribute, '您设置的域名已经被占用，请重新设置！');
            }

        }
    }

    /**
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info($where = []) {
        if (empty($where)) {
            return false;
        }

        $obj = self::findOne($where);
        if (!empty($obj)) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list($where = [], $order = 'created_at desc', $page = 1, $limit = 20) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        $_obj->orderBy($order);

        if (!empty($limit)) {
            $offset = ($page - 1) * $limit;
            $_obj->offset($offset)->limit($limit);
        }

        return $_obj->asArray(true)->all();
    }

    /**
     * 保存记录
     * @param $data array
     * @return array|boolean
     */
    public function _save($data) {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                if (!empty($data['id'])) {//修改
                    $id = $data['id'];
                    $ret = $_mdl->updateAll($data, ['id' => $id]);
                } else {//增加
                    foreach ($data as $k => $v) {
                        $_mdl->$k = $v;
                    }
                    if($_mdl->validate()){
                        $ret = $_mdl->insert();
                    }else{
                        return false;
                    }
                }

                if ($ret !== false) {
                    return true;
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 删除记录
     * @param $where array
     * @return array|boolean
     */
    public static function _delete($where) {
        if (empty($where)) {
            return false;
        }
        try {
            return (new self)->deleteAll($where);
        } catch (Exception $e) {

        }
        return false;
    }
    /**
     * 获取用户名对应的二级域名
     * @param type $username
     * @return type
     */
    public static function getUserSubdomain($username)
    {        
        $username_domain=yii::$app->redis->get('mall_domain_username_'.md5($username));
        if(empty($username_domain))
        {
            $username_domain=self::find()->select('subdomain')->where(['username'=>$username])->scalar();
            if($username_domain)
            {
                yii::$app->redis->set('mall_domain_username_'.md5($username),$username_domain);
            }
        }
        return $username_domain;
    }
    /**
     * 获取二级域名对应的用户名
     * @param type $domain
     * @return type
     */
    public static function getSubdomainUser($domain)
    {
        $domain_username=yii::$app->redis->get('mall_username_domain_'.$domain);
        if(empty($domain_username))
        {
            $domain_username=self::find()->select('username')->where(['subdomain'=>$domain])->scalar();
            if($domain_username)
            {
                yii::$app->redis->set('mall_username_domain_'.$domain,$domain_username);
            }
        }
        return $domain_username;        
    }

}
