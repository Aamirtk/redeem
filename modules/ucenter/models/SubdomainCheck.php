<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/05/09
 * Time: 17:00
 */
namespace frontend\modules\ucenter\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "{{%subdomain_check}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $subdomain
 * @property integer $check_status
 * @property integer $checker_id
 * @property string $deny_reason
 * @property integer $created_at
 * @property integer $updated_at
 */
class SubdomainCheck extends \yii\db\ActiveRecord
{
    /**
     * 审核状态
     */
    const CHECK_WAIT = 1;//待审核
    const CHECK_PASS = 2;//审核通过
    const CHECK_DENY = 3;//审核未通过
    const CHECK_FORBIDEN = 4;//禁用

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subdomain_check}}';
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
            [['check_status', 'checker_id', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['subdomain'], 'string', 'max' => 15],
            [['deny_reason'], 'string', 'max' => 150],
            [['created_at', 'updated_at'], 'default', 'value' => time()],
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
            'check_status' => '审核状态（1-待审核；2-审核通过；3-审核未通过；4-禁用）',
            'checker_id' => '审核人员ID',
            'deny_reason' => '审核未通过原因',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
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
    public function _delete($where) {
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
     * 获取用户最近一条审核记录
     * @param $where string|string 查询条件
     * @return array|boolean
     */
    public function _rencent_check($where) {
        if(empty($where)){
            return false;
        }
        $mdl = new self();
        $check = $mdl->find()
            ->where($where)
            ->orderBy('id desc')
            ->asArray(true)
            ->one();
        return $check;
    }

    /**
     * 获取审核状态，记录等
     * @param $username string
     * @return array|boolean
     */
    public function _get_check_info($username) {
        if(empty($username)){
            return false;
        }
        //判断是否有待审核记录
        $mdl = new SubdomainUser();
        $mdl_ch = new self;
        $subdomain = $mdl->_get_info([
            'username' => $username
        ]);
        $check = $mdl_ch->_rencent_check(['username' => $username]);
        if($subdomain){//审核通过
            $step = 3;
            $my_domain = $subdomain['subdomain'] . '.' . yiiParams('main_url');
            $button = '';
        }else{
            if(!$check){
                $step = 1;//未曾申请
                $my_domain = strtolower($username) . '.' . yiiParams('main_url');
                $button = '';
            }else if($check['check_status'] == $mdl_ch::CHECK_WAIT){
                $step = 2;//待审核
                $my_domain = $check['subdomain'] . '.' . yiiParams('main_url');
                $button = '待审核';
            }else if($check['check_status'] == $mdl_ch::CHECK_DENY){
                $step = 4;//审核未通过
                $my_domain = $check['subdomain'] . '.' . yiiParams('main_url');
                $button = '审核未通过';
            }else if($check['check_status'] == $mdl_ch::CHECK_FORBIDEN){
                $step = 5;//被重置
                $my_domain = strtolower($username) . '.' . yiiParams('main_url');
                $button = '被重置';
            }else{
                $step = 1;
                $my_domain = strtolower($username) . '.' . yiiParams('main_url');
                $button = '';
            }
        }
        return [
            'check' => $check,
            'step' => $step,
            'my_domain' => $my_domain,
            'button' => $button,
        ];
    }





}
