<?php

namespace frontend\modules\enterprise\models;

use Yii;
use common\models\CommonCrmCompany;
use frontend\modules\talent\models\User;
class CrmCompany extends CommonCrmCompany
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'province',
                    'city',
                    'qq',
                    'tel',
                    'uptime',
                    'upuser',
                    'score_status',
                    'status',
                    'has_original',
                    'is_render',
                    'has_develop',
                    'has_prize',
                    'update_time',
                    'record_is_show',
                ],
                'integer'
            ],
            [['description', 'scoreArr', 'reg_money', 'reg_time', 'nature', 'aptitude'], 'string'],
            [['username', 'contact_name', 'contact_postion'], 'string', 'max' => 20],
            [['name', 'upusername'], 'string', 'max' => 50],
            [['logo', 'banner', 'address', 'site_url', 'turnover', 'output'], 'string', 'max' => 100],
            [['contact_wechat'], 'string', 'max' => 30],
            [['contact_email'], 'string', 'max' => 80]
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
            'name' => 'Name',
            'logo' => 'Logo',
            'banner' => 'Banner',
            'province' => 'Province',
            'city' => 'City',
            'address' => 'Address',
            'qq' => 'Qq',
            'tel' => 'Tel',
            'contact_name' => 'Contact Name',
            'contact_postion' => 'Contact Postion',
            'contact_wechat' => 'Contact Wechat',
            'contact_email' => 'Contact Email',
            'description' => 'Description',
            'site_url' => 'Site Url',
            'uptime' => 'Uptime',
            'upuser' => 'Upuser',
            'upusername' => 'Upusername',
            'scoreArr' => 'Score Arr',
            'score_status' => 'Score Status',
            'status' => 'Status',
            'reg_money' => 'Reg Money',
            'reg_time' => 'Reg Time',
            'nature' => 'Nature',
            'aptitude' => 'Aptitude',
            'turnover' => 'Turnover',
            'output' => 'Output',
            'has_original' => 'Has Original',
            'is_render' => 'Is Render',
            'has_develop' => 'Has Develop',
            'has_prize' => 'Has Prize',
            'update_time' => 'Update Time',
            'record_is_show' => 'Record Is Show'
        ];
    }

    /**
     * 获取列表 rj
     * */
    public static function getList($where = [], $order = '')
    {
        return self::find()
            ->where($where)
            ->orderBy($order)
            ->asArray(true)
            ->all();
    }

    /**
     * 获取单个文件 rj
     * */
    public static function getInfo($where = [], $order = '')
    {
        if (empty($where))
        {
            return false;
        }
        $company=[];
        $obj = self::find()->where($where)->orderBy($order)->one();
        if (!empty($obj))
        {
           $company = $obj->toArray();
            //vip等级信息
            $uservipinfo = json_decode(yii::$app->redis->get("VSO_VIP_" . md5($company['username'])),true);
            $company['user_vip_lv'] = $uservipinfo[0]?$uservipinfo[0]:1;
            $company['user_vip_lvname'] = $uservipinfo[1]?$uservipinfo[1]:'普通会员';
        }
        return $company;

    }

    /**
     * 设置信息 rj
     */
    public static function setInfo($data, $username)
    {
        if (!$data || !is_array($data))
        {
            return false;
            //throw new CDbException(Yii::t('ext.RDbCommand', 'Columns should be a valid one demention array.'));
        }

        $obj = self::find()->where(['id' => $data['id']])->one();

        if (!empty($obj))
        {
            $obj->setAttributes($data);
            $obj->setAttribute("update_time", time());
            return $obj->update();
        }
        else
        {
            $model = new EntCase();
            foreach ($data as $key => $val)
            {
                $model->setAttribute($key, $val);
            }

            return $model->insert();
        }
    }

    /**
     * 获取CRM录入员分组
     * role_id = 8
     * @return array
     */
    public static function getAdminUserArr($username)
    {
        // 管理员数组，在frontend params.php
//        return yii::$app->params['rc_frontend_admin_list'];
        $rows = self::findBySql("SELECT * FROM tb_admin where username = '$username' and role_id = 8 ")->one();
        if($rows){
            return true;
        }else{
            return false;
        }

    }

    /**
     * 管理员权限判断
     * @param $obj_username，被访问用户的用户名
     * @return bool（true=>有权限，false=>无权限）
     */
    public static function isUserSelf($obj_username)
    {
        // 被访问用户为空，非法，没有权限
        if (empty($obj_username))
        {
            return false;
        }
        // 当前登录用户即为被访问用户，有权限
        $username = User::getLoginedUsername();
        if ($username == $obj_username)
        {
            return true;
        }
        // 当前登录用户属于管理员列表，有权限
        return self::getAdminUserArr($username);
    }

    /**
     * 用户是否属于公司管理员
     * @param $username
     * @return bool（true=>是，false=>否）
     */
    public static function isCompanyOwner($username)
    {
        $exist = self::find()
            ->where(['username' => $username])
            ->count();
        return $exist ? true : false;
    }

    /**
     * 根据username获取其他信息
     * @param $username
     * @return array
     */
    public static function getCrmCompanyInfo($username)
    {
        $info = self::find()
            ->where(['username' => $username])
            ->asArray()->one();
        return $info;
    }
}
