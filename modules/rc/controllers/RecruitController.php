<?php

/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/11/2
 * Time: 15:49
 */

namespace frontend\modules\rc\controllers;

use yii;
use yii\web\Controller;
use common\api\VsoApi;
use common\lib\Industry;
use frontend\modules\talent\models\User;
use frontend\modules\personal\models\Work;
use frontend\modules\enterprise\models\CrmCompany;
class RecruitController extends Controller
{

    public $layout               = false;
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        //当前登录用户
        $vso_uname = User::getLoginedUsername();
        return $this->render('recruiting',['_this_obj'  => $this,
            'vso_uname'  => $vso_uname]);
    }
    /**
     * 企业入驻按钮事件
     */
    public function actionRegister()
    {
        //当前登录用户
        $vso_uname = User::getLoginedUsername();
        //是否有个人入驻申请信息
        $getPersonalApplyInfoUrl    = yii::$app->params['getPersonalApplyInfoUrl'];
        $applyInfo   = VsoApi::send($getPersonalApplyInfoUrl, ['username'=>$vso_uname], "get");
        if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1)))
        {
            $result['ret']=13841;
            $result['message']='您已申请了个人入驻,不能再申请企业入驻了';
            echo json_encode($result);
            exit;
        }
        // 是否是人才库中的人才
        if (User::isTalentExistByUsername($vso_uname))
        {
            $result['ret']=14000;
            echo json_encode($result);
            exit;
        }
        //是否进行企业认证
        $apiRcEnterpriseUrl      = yii::$app->params['apiRcEnterpriseUrl'];
        $result   = VsoApi::send($apiRcEnterpriseUrl, ['username' => $vso_uname], "post");
        echo json_encode($result);
    }
    /**
     * 企业认证
     * @return type
     */
    public function actionEnterprise()
    {   //当前登录用户
        $vso_uname = User::getLoginedUsername();
//        // 是否已经是crm中的企业用户
//        $company_id = CrmCompany::getCompanyidByUsername($vso_uname);
//        if (!empty($company_id))
//        {
//            return $this->redirect("http://rc.vsochina.com/enterprise/default/index/{$vso_uname}");
//        }
        // 是否是人才库中的人才
        if (User::isTalentExistByUsername($vso_uname))
        {
            return $this->redirect("http://rc.vsochina.com/talent/{$vso_uname}");
        }
        //是否有个人入驻申请信息
        $getPersonalApplyInfoUrl    = yii::$app->params['getPersonalApplyInfoUrl'];
        $applyInfo   = VsoApi::send($getPersonalApplyInfoUrl, ['username'=>$vso_uname], "get");
        if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1)))
        {
            return $this->redirect('http://rc.vsochina.com/rc/recruit/personal');
        }
        //获取企业认证信息
        $apiAuthEnterpriseUrl     = yii::$app->params['apiAuthEnterpriseUrl'];
        $authInfo   = VsoApi::send($apiAuthEnterpriseUrl, ['username'=>$vso_uname], "get");
        if(!empty($authInfo['data'])&&isset($authInfo['data']['auth_status'])&&(1==$authInfo['data']['auth_status']))
        {
            $data['authInfo']=$authInfo['data'];
            return $this->render('recruiting',['_this_obj'  => $this,
            'vso_uname'  => $vso_uname]);
        }
        //获取用户基本信息
        $vsoInfoUrl      = yii::$app->params['user_detail'];
        $result   = VsoApi::send($vsoInfoUrl, ['username'=>$vso_uname], "get");
        if(!empty($result['data']))
        {
            $data['vsoInfo']=$result['data'];
            $data["vsoInfo"]["local"] = explode(',', $result['data']["residency"]);
        }
        //行业分类
        $data['indusJson'] =Industry::industryToJson();
        $data['indus_p_arr']=$this->getIndustry();
        //营业执照图片
        $file_url    = yii::$app->request->get('workfile') ? $this->getThumb(urldecode(yii::$app->request->get('workfile'))) : '';
        return $this->render('enterprise',['_this_obj'  => $this,
            'vso_uname'  => $vso_uname,'data'=>$data,'file_url'=>$file_url,
            'authInfo'=>isset($authInfo['data'])?$authInfo['data']:array()]);
    }
    /**
     * 企业认证申请
     */
    public function actionCreateEnterprise()
    {
        $postdata=yii::$app->request->post();
        if(empty($postdata))
        {
            $authInfo['ret']=13834;
            $authInfo['message']='信息不完整,请确认后再提交';
            echo json_encode($authInfo);
            exit;
        }
        if(empty($postdata['indus_pid']))
        {
            $authInfo['ret']=13834;
            $authInfo['message']='请填写经营范围';
            echo json_encode($authInfo);
            exit;
        }
        if(empty($postdata['province']))
        {
            $authInfo['ret']=13834;
            $authInfo['message']='请填写所属地区';
            echo json_encode($authInfo);
            exit;
        }
        //获取企业认证信息
        $apiAuthEnterpriseUrl     = yii::$app->params['apiAuthEnterpriseUrl'];
        $res   = VsoApi::send($apiAuthEnterpriseUrl, ['username'=>$postdata['username']], "get");
        if((!empty($res['data']))&&(isset($res['data']['auth_status']))&&($res['data']['auth_status']==0))
        {
            $authInfo['ret']=13830;
            $authInfo['message']='入驻申请提交成功,信息正在审核中,请耐心等待';
            echo json_encode($authInfo);
            exit;
        }
        $apiCreateEnterpriseUrl= yii::$app->params['apiCreateEnterpriseUrl'];
        $authInfo   = VsoApi::send($apiCreateEnterpriseUrl, ['postdata'=>$postdata], "post");
        echo json_encode($authInfo);
    }
    /**
     * 获取一级行业分类
     * @return type
     */
    public function getIndustry()
    {
        //取redis里的
        $redis      = yii::$app->redis;
        $industries = json_decode($redis->get('rc:industries:lvl:0:'), true);
        if (empty($industries))
        {
            $industryUrl = yii::$app->params['industryListUrl'];
            $industry    = VsoApi::send($industryUrl, ['lvl' => 0], "get");
            if (0 == $industry['ret'])
            {
                $industries = $industry['data'];
            }
            $redis->set('rc:industries:lvl:0:', json_encode($industries));
            $redis->expire('rc:industries:lvl:0:', 604800);
        }
        return $industries;
    }
    /**
     * 校验企业用户名是否可用
     */
    public function actionValidateEnterpriseName($enterprise)
    {
        //获取企业认证信息
        $apiEnterpriseInfoByNameUrl     = yii::$app->params['apiEnterpriseInfoByNameUrl'];
        $result   = VsoApi::send($apiEnterpriseInfoByNameUrl, ['company'=>  urldecode($enterprise)], "get");
        echo $result['data']['scalar']? "false" : "true";
    }
    /**
     * 校验个人用户手机号是否可用
     */
    public function actionValidatePersonalMobile($mobile)
    {
        //获取手机认证信息
        $validLoginedMobileUrl     = yii::$app->params['validLoginedMobileUrl'];
        $result   = VsoApi::send($validLoginedMobileUrl, ['mobile'=>  urldecode($mobile)], "get");
        echo $result['data']['isValid']? "true" : "false";
    }
    /**
     * 获取营业执照图片的缩略图
     * @param type $img
     * @return string
     */
    public function getThumb($img)
    {
        $img_arr       = explode(".", $img);
        $format        = "." . end($img_arr);
        if(!in_array($format, array('.jpg', '.jpeg', '.png', '.gif', '.bmp')))
        {
            return '';
        }
        $new_format = "_230" . $format;
        $img_src = str_replace($format, $new_format, $img);
        return $img_src;
    }
    /**
     * 个人入驻按钮事件
     */
    public function actionApply()
    {
        //当前登录用户
        $vso_uname = User::getLoginedUsername();
        if(empty($vso_uname))
        {
            $result['ret']=9003;
            echo json_encode($result);
            exit;
        }
//        // 是否已经是crm中的企业用户
//        $company_id = CrmCompany::getCompanyidByUsername($vso_uname);
//        if (!empty($company_id))
//        {
//            $result['ret']=14000;
//            echo json_encode($result);
//            exit;
//        }
        // 是否是人才库中的人才
        if (User::isTalentExistByUsername($vso_uname))
        {
            $result['ret']=14000;
            echo json_encode($result);
            exit;
        }
        //如果有申请企业认证信息
        $apiAuthEnterpriseUrl     = yii::$app->params['apiAuthEnterpriseUrl'];
        $res   = VsoApi::send($apiAuthEnterpriseUrl, ['username'=>$vso_uname], "get");
        if((!empty($res['data']))&&(isset($res['data']['auth_status']))&&($res['data']['auth_status']>=0))
        {
            $result['ret']=13841;
            echo json_encode($result);
            exit;
        }
        //获取个人入驻申请信息
        $getPersonalApplyInfoUrl    = yii::$app->params['getPersonalApplyInfoUrl'];
        $applyInfo  = VsoApi::send($getPersonalApplyInfoUrl, ['username'=>$vso_uname], "get");
        if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1)))
        {
            $result['ret']=13840;
            echo json_encode($result);
            exit;
        }elseif((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==3)))
        {
            $result['ret']=13839;
            echo json_encode($result);
            exit;
        }
        $result['ret']=13837;
        echo json_encode($result);
    }
    /**
     * 个人入驻
     * @return type
     */
    public function actionPersonal()
    {   //当前登录用户
        $vso_uname = User::getLoginedUsername();
        // 是否是人才库中的人才
        if (User::isTalentExistByUsername($vso_uname))
        {
            return $this->redirect("http://rc.vsochina.com/talent/{$vso_uname}");
        }
        //获取用户基本信息
        $vsoInfoUrl      = yii::$app->params['user_detail'];
        $result   = VsoApi::send($vsoInfoUrl, ['username'=>$vso_uname], "get");
//        // 是否已经是crm中的企业用户
//        $company_id = CrmCompany::getCompanyidByUsername($vso_uname);
//        if (!empty($company_id))
//        {
//            return $this->redirect("http://rc.vsochina.com/enterprise/default/index/{$vso_uname}");
//        }

        //如果有申请企业认证信息
        $apiAuthEnterpriseUrl     = yii::$app->params['apiAuthEnterpriseUrl'];
        $res   = VsoApi::send($apiAuthEnterpriseUrl, ['username'=>$vso_uname], "get");
        if((!empty($res['data']))&&(isset($res['data']['auth_status']))&&($res['data']['auth_status']==0))
        {
            return $this->redirect('http://rc.vsochina.com/rc/recruit/enterprise');
        }
        //获取个人入驻申请信息
        $getPersonalApplyInfoUrl    = yii::$app->params['getPersonalApplyInfoUrl'];
        $applyInfo  = VsoApi::send($getPersonalApplyInfoUrl, ['username'=>$vso_uname], "get");
        if((isset($applyInfo['data']['status'])&&($applyInfo['data']['status']==1)))
        {
            $workInfo=Work::_get_work($applyInfo['data']['work_id']);
            $applyInfo['data']['work_url']=isset($workInfo['data']['work_url'])?$workInfo['data']['work_url']:'';
        }
        //个人作品图片
        $file_url    = yii::$app->request->get('workfile') ? $this->getThumb(urldecode(yii::$app->request->get('workfile'))) : '';
        return $this->render('personal',['_this_obj'  => $this,
            'vso_uname'  => $vso_uname,'userInfo'=>$result['data'],
            'file_url'=>$file_url,'applyInfo'=>$applyInfo]);
    }
    /**
     * 发送手机验证码根据用户名和手机号(未绑定手机号的用户)
     * @param type $mobile
     */
    public function actionSendValidCode()
    {
        $mobile=yii::$app->request->post('mobile');
        //当前登录用户
        $vso_uname = User::getLoginedUsername();
        $is_mobile=preg_match("/^1[34578][0-9]{9}$/", $mobile) ? true : false;
        if(!$is_mobile)
        {
            $authInfo['ret']=13834;
            $authInfo['message']='手机号码不正确';
            echo json_encode($authInfo);
            exit;
        }
        //获取手机认证信息
        $validLoginedMobileUrl     = yii::$app->params['validLoginedMobileUrl'];
        $result   = VsoApi::send($validLoginedMobileUrl, ['mobile'=>  urldecode($mobile)], "get");
        if(!$result['data']['isValid'])
        {
            $authInfo['ret']=13834;
            $authInfo['message']='手机号码已申请了认证，如非本人申请，请联系客服 400-164-7979';
            echo json_encode($authInfo);
            exit;
        }
        //发送手机验证码
        $vsoInfoUrl      = yii::$app->params['sendMobileValidCodeUrl'];
        $result   = VsoApi::send($vsoInfoUrl, ['username'=>$vso_uname,'mobile'=>$mobile], "post");
        echo json_encode($result);
    }
    /**
     * 个人认证申请
     */
    public function actionCreatePersonal()
    {
        $postdata=yii::$app->request->post();
        if(empty($postdata))
        {
            $authInfo['ret']=13834;
            $authInfo['message']='信息不完整,请确认后再提交';
            echo json_encode($authInfo);
            exit;
        }
        if(empty($postdata['work_url']))
        {
            $authInfo['ret']=13834;
            $authInfo['message']='请上传作品图片';
            echo json_encode($authInfo);
            exit;
        }
        //校验验证码
        if($postdata['valid_code'])
        {
            $checkMobileValidCodeUrl     = yii::$app->params['checkMobileValidCodeUrl'];
            $res   = VsoApi::send($checkMobileValidCodeUrl, ['username'=>$postdata['username'],
                'valid_code'=>$postdata['valid_code']], "post");
            if($res['ret']!=13540)
            {
                $authInfo['ret']=13540;
                $authInfo['message']='验证码不正确';
                echo json_encode($authInfo);
                exit;
            }
        }
        //获取个人入驻申请信息
        $apiAuthEnterpriseUrl     = yii::$app->params['getPersonalApplyInfoUrl'];
        $res   = VsoApi::send($apiAuthEnterpriseUrl, ['username'=>$postdata['username']], "get");
        if((!empty($res['data']))&&($res['data']['status']==1))
        {
            $authInfo['ret']=13830;
            $authInfo['message']='入驻申请提交成功,信息正在审核中,请耐心等待';
            echo json_encode($authInfo);
            exit;
        }
        //创建作品
        $workData['username']=$postdata['username'];
        $workData['workname']='未命名作品';
        $workData['workfile']=  str_replace('_230', '', $postdata['work_url']);
        $workData['objtype']='work';
        $workResult=Work::_add_work($workData);
        $postdata['work_id']=isset($workResult['data']['workid'])?$workResult['data']['workid']:'';
        //创建个人入驻申请
        $postdata['mobile']=$postdata['mobile']?$postdata['mobile']:$postdata['hiddenmobile'];
        $postdata['introduction']=strip_tags($postdata['introduction']);
        $apiCreateEnterpriseUrl= yii::$app->params['createPersonalApplyUrl'];
        $authInfo   = VsoApi::send($apiCreateEnterpriseUrl, ['postdata'=>$postdata], "post");
        echo json_encode($authInfo);
    }
}
