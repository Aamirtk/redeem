<?php

namespace backend\modules\vip\models;

use Yii;
use backend\modules\vip\models\VipPrivileges;
use app\modules\team\models\Team;
use common\api\VsoApi;

/**
 * This is the model class for table "vso_vips".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property integer $group_id
 * @property string $contact
 * @property integer $phone
 * @property string $address
 * @property string $pay
 * @property integer $inputer_id
 * @property integer $check_status
 * @property integer $created_at
 */
class Vips extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_vips';
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
            [['group_id', 'phone', 'inputer_id','check_status', 'created_at'], 'integer'],
            [['pay'], 'number'],
            [['username', 'name', 'contact'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 120],
            [['username'], 'unique'],
            [['username'], 'validateUsername'],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户注册ID',
            'name' => '用户名称',
            'group_id' => '用户等级ID',
            'contact' => '联系人姓名',
            'phone' => '联系电话',
            'address' => '联系地址',
            'pay' => '应缴纳金额',
            'inputer_id' => '录入人员角色ID',
            'check_status' => '审核状态（0-录入中；1-财务管理员待审核；2-财务管理员审核驳回；3-运营管理员待审核；4-运营管理员审核驳回；5-运营管理员审核通过）',
            'created_at' => '创建时间',
        ];
    }

    /**
     * 验证平台注册ID
     */
    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if(!$this->getUserInfoByName($this->username)){
                $this->addError($attribute, '找不到对应的用户信息，请确认无误。');
            }
        }
    }


    /**
     * 获取权限信息
     * @return object
     */
    public function getVipGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }

    /**
     * 获取会员权限
     * @return object
     */
    public function getPrivileges()
    {
        return $this->hasOne(VipPrivileges::className(), ['username'=>'username']);
    }

    /**
     * 获取审核信息
     * @return object
     */
    public function getCheckRecords()
    {
        return $this->hasMany(Check::className(), ['username' => 'username']);
    }

    /**
     * 获取审核信息
     * @return object
     */
    public function getCheckStates($in = [])
    {
        $query = $this->hasMany(Check::className(), ['username'=>'username']);
        return $in ? $query->where(['in', 'check_status', $in]) : $query;
    }


    /**
     * 获取录入人员信息
     * @return object
     */
    public function getInputer()
    {
        return $this->hasOne(Team::className(), ['uid' => 'inputer_id']);
    }

    /**
     * 获取信息管理员公司信息
     * @return object
     */
    public static function getCheckerCompany($company_id)
    {
        $companys = yii::$app->params['lhtxcompany'];
        return isset($companys[$company_id]) ? $companys[$company_id] : $companys[5];
    }

    /**
     * 通过接口获取用户信息
     * @param $usrename
     * @return bool
     **/
    public function getUserInfoByName($username)
    {
        $url = yii::$app->params['userinfoapi'];
        $data = [
            'username' => $username,
        ];
        $result = VsoApi::send($url, $data, 'get');
        if (isset($result['ret']) && $result['ret'] == 13020)
        {
            return $result['data'];
        }else{
            return false;
        }
    }


    /**
     * 获取会员信息列表
     * @return array
     */
    public static function getVipList()
    {

    }


    /**
     * 获取审查状态列表
     * 审核状态（0-信息管理员待审核；1-信息管理员审核驳回；2-财务管理员待审核；3-财务管理员审核驳回；
     *         4-运营管理员待审核；5-运营管理员审核驳回；6-运营管理员审核通过）
     * @return array
     */
    public static function getCheckStatus($plg = 'add')
    {
        return [
            '0' => '录入中',
            '1' => '财务待审核',
            '2' => '财务审核驳回',
            '3' => '运营待审核',
            '4' => '运营审核驳回',
            '5' => '运营审核通过',
        ];
//        if ($plg == 'info')
//        {
//            return [
//                '0' => '录入中',
//                '1' => '财务待审核',
//                '2' => '财务审核驳回',
//                '3' => '运营待审核',
//                '4' => '运营审核驳回',
//                '5' => '运营审核通过',
//            ];
//        }
//        else if ($plg == 'finance')
//        {
//            return [
//                '0' => '录入中',
//                '1' => '财务待审核',
//                '2' => '财务审核驳回',
//                '3' => '运营待审核',
//                '4' => '运营审核驳回',
//                '5' => '运营审核通过',
//            ];
//        }
//        else if ($plg == 'operate')
//        {
//            return [
//                '0' => '录入中',
//                '1' => '财务待审核',
//                '2' => '财务审核驳回',
//                '3' => '运营待审核',
//                '4' => '运营审核驳回',
//                '5' => '运营审核通过',
//            ];
//        }
//        else
//        {
//            return [
//                '0' => '录入中',
//                '1' => '财务待审核',
//                '2' => '财务审核驳回',
//                '3' => '运营待审核',
//                '4' => '运营审核驳回',
//                '5' => '运营审核通过',
//            ];
//        }
    }


    /**
     * 获取审查状态名称
     * @return string
     */
    public static function getCheckStatusName($status = 0)
    {
        $statusArr = self::getCheckStatus();
        return isset($statusArr[$status]) ? $statusArr[$status] : '';

    }

    /**
     * 获取筛选方式列表
     * @return array
     */
    public static function getSelcetTypes()
    {
        return [
            '1' => '按客户名称',
            '2' => '客户用户ID',
            '3' => '按销售员姓名',
            '4' => '按公司名称',
        ];
    }


}
