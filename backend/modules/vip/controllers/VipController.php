<?php
namespace backend\modules\vip\controllers;

use backend\modules\vip\models\Check;
use backend\modules\vip\models\VipIndustries;
use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use app\base\CommonWebController;
use backend\modules\vip\models\Vips;
use backend\modules\vip\models\Groups;
use backend\modules\vip\models\VipPrivileges;
use backend\modules\opportunity\models\OpportunityUser;
use app\modules\team\models\Team;
use common\models\Industry;

class VipController extends CommonWebController
{
    public $layout = 'layout';
    public $privilege = '';

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'list',
            'list-info',
            'list-view',
            'list-finance',
            'list-operate',
            'add',
            'update',
            'ajax-save-vip',
            'delete',
            'ajax-load-group-detail',
            'detail',
            'finance-check',
            'operate-check',
            'ajax-finance-check',
            'ajax-operate-check',
            'add-serial-img',
            'ajax-check-user',
            'ajax-get-user-info',
            'edit-industries',
            'ajax-save-vip-indust',
            'ajax-load-indust',
        ];
    }

    /**
     * 基础维护管理列表
     * @return string
     */
    public function actionList()
    {
        $isAjax = $this->getHttpParam('ajax', false, false);
        if ($isAjax)
        {
            $this->getVipList('add');
        }
        else
        {
            $data = $this->getFilterList('add');
            return $this->render('list', $data);
        }
    }

    /**
     * 信息管理员查看会员列表
     * @return array
     */
    public function actionListInfo()
    {
        $isAjax = $this->getHttpParam('ajax', false, false);
        if ($isAjax)
        {
            $this->getVipList('info');
        }
        else
        {
            $data = $this->getFilterList('info');
            return $this->render('list', $data);
        }
    }

    /**
     * 财务查看会员列表
     * @return array
     */
    public function actionListFinance()
    {
        $isAjax = $this->getHttpParam('ajax', false, false);
        if ($isAjax)
        {
            $this->getVipList('finance');
        }
        else
        {
            $data = $this->getFilterList('finance');
            return $this->render('list', $data);
        }
    }

    /**
     * 运营查看会员列表
     * @return array
     */
    public function actionListOperate()
    {
        $isAjax = $this->getHttpParam('ajax', false, false);
        if ($isAjax)
        {
            $this->getVipList('operate');
        }
        else
        {
            $data = $this->getFilterList('operate');
            return $this->render('list', $data);
        }
    }

    /**
     * 获取筛选条件
     * @return array
     */
    public function getFilterList($_plg = 'info')
    {
        $_data = [];
        //获取会员等级列表
        $_data['groupList'] = Groups::getGroupList();
        //审核状态列表
        $_data['checkSatus'] = Vips::getCheckStatus($_plg);
        //筛选方式列表
        $_data['selectTypes'] = Vips::getSelcetTypes();
        //公司列表
        $_data['companyList'] = yii::$app->params['lhtxcompany'];
        //权限
        $_data['privilege'] = $_plg;

        return $_data;
    }

    /**
     * 异步获取会员列表
     * @return array
     */
    public function getVipList($_plg = 'info')
    {
        $this->privilege = $_plg;
        $query = Vips::find();
        $search = $this->getHttpParam('search', false, null);
        $privilege = $this->getHttpParam('privilege', false, 'add');
        $page = $this->getHttpParam('page', false, 0);
        $pageSize = $this->getHttpParam('pageSize', false, 10);
        $offset = $page * $pageSize;
        $memTb = Vips::tableName();
        $teamTb = Team::tableName();
        if ($search)
        {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', $memTb . '.created_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', $memTb . '.created_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['grouptype'])) //时间范围
            {
                $query = $query->andWhere(['group_id' => $search['grouptype']]);
            }
            if (isset($search['filtertype']) && !empty($search['filtercontent']))
            {
                if ($search['filtertype'] == 2)//按照用户名称筛选
                {
                    $query = $query->andWhere(['like', $memTb . '.name', trim($search['filtercontent'])]);
                }
                elseif ($search['filtertype'] == 1)//按照用户ID筛选
                {
                    $query = $query->andWhere([$memTb . '.username' => trim($search['filtercontent'])]);
                }
            }
            if (isset($search['inputer']) && !empty($search['inputer']))
            {
                $query = $query->andWhere(['like', $teamTb . '.nickname', trim($search['filtercontent'])]);
            }
            if (isset($search['inputercompany'])) //筛选条件
            {
                $query = $query->andWhere([$teamTb . '.company_id' => $search['inputercompany']]);
            }
            if (isset($search['checkstatus'])) //筛选条件
            {
                $query->andWhere([$memTb . '.check_status' => $search['checkstatus']]);
            }
        }

        if($privilege == 'info'){
//            $query = $query->andWhere(['in', $memTb . '.check_status' , [0, 2]]);
            //只查看自己所录入的
            $query = $query->andWhere(['inputer_id' => Yii::$app->user->identity->uid]);
        }else if($privilege == 'finance'){
            $query = $query->andWhere(['in', $memTb . '.check_status' , [1, 4]]);
        }else if($privilege == 'operate'){
            $query = $query->andWhere(['in', $memTb . '.check_status' , [3]]);
        }
        $_order_by = 'id ASC';
        $vipArr = $query
            ->joinWith('inputer')
            ->joinWith('checkRecords')
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $vipList = ArrayHelper::toArray($vipArr, [
            'backend\modules\vip\models\Vips' => [
                'id',
                'username',
                'name',
                'contact',
                'phone',
                'address',
                'check_status',
                'pay' => function ($m) {
                    return $m->pay . '元';
                },
                'price' => function ($m) {
                    return $m->vipGroup ? $m->vipGroup->price . '元' : '0.00元';
                },
                'vipgroup' => function ($m) {
                    return $m->vipGroup ? $m->vipGroup->name : '非会员';
                },
                'inputer' => function ($m) {
                    return $m->inputer ? $m->inputer->nickname : '';
                },
                'inputer_compamy' => function ($m) {
                    return $m->inputer ? Vips::getCheckerCompany($m->inputer->company_id) : '';
                },
                'checker' => function ($m) {
                    return $this->getCheckInfo($m->username, $m->check_status);
                },
                'created_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->created_at);
                },

            ],
        ]);
        $this->printSuccess(['vipList' => $vipList, 'totalCount' => count($vipList)]);
    }

    /**
     * 会员查看
     * @return array
     */
    public function actionDetail()
    {
        $mid = intval($this->getHttpParam('id', false, 0));
        $vip = Vips::find()
            ->where('id = :mid', [':mid' => $mid])
            ->with('vipGroup')
            ->with('privileges')
            ->asArray()
            ->one();
        $vip['input_time'] = date('Y-m-d H:i:s', $vip['created_at']);
        $vip['group_name'] = isset($vip['privileges']['group_name']) ? $vip['privileges']['group_name'] : '';
        $vip['price'] = isset($vip['vipGroup']['price']) ? $vip['vipGroup']['price'] : 0;
        $vip['buy_num'] = isset($vip['privileges']['buy_num']) ? $vip['privileges']['buy_num'] : 0;
        $vip['check_state'] = Vips::getCheckStatusName($vip['check_status']);
        //财务驳回和运营驳回
        if(in_array($vip['check_status'], [2, 4])){
            $check = Vips::findOne(['id' => $mid])->getCheckStates([$vip['check_status']])->asArray()->one();
            $vip['check_reason'] = $check ? $check['unpassed_reason'] : '';
        }


        //有效开始和截止时间等
        if (isset($vip['privileges']))
        {
            $valid_begin = $vip['privileges']['valid_begin'];
            $valid_end = strtotime('+'. $vip['privileges']['buy_num'] .' year', $valid_begin);
            $vip['valid_begin'] = $valid_begin > 0 ? date('Y-m-d H:i:s', $valid_begin) : '';
            $vip['valid_end'] = $valid_begin > 0 ? date('Y-m-d H:i:s', $valid_end) : '';
        }
        else
        {
            $vip['valid_begin'] = '';
            $vip['valid_end'] = '';
        }

        $_data = [
            'groups' => Groups::getGroupList(),
            'durations' => Groups::getDurationList(),
            'vip' => $vip,
        ];
        return $this->render('detail', $_data);
    }

    /**
     * 添加会员
     * @return array
     */
    public function actionAdd($_plg = 'info')
    {

        $_data = [
            'groups' => Groups::getGroupList(),
            'durations' => Groups::getDurationList(),
        ];

        return $this->render('add', $_data);
    }

    /**
     * 编辑会员
     * @return array
     */
    public function actionUpdate($_plg = 'info')
    {
        $mid = intval($this->getHttpParam('mid', false, 0));
        $vip = Vips::find()->where('id = :mid', [':mid' => $mid])->with('vipGroup')->asArray()->one();
        $vip['price'] = ArrayHelper::getValue($vip, 'vipGroup.price', 0);
        $_data = [
            'groups' => Groups::getGroupList(),
            'durations' => Groups::getDurationList(),
            'vip' => $vip,
        ];

        return $this->render('update', $_data);
    }

    /**
     * 保存会员信息
     * @return array
     */
    public function actionAjaxSaveVip()
    {
        $mid = intval($this->getHttpParam('mid', false, 0));
        $action = trim($this->getHttpParam('action_type', false, 'add'));
        $username = trim($this->getHttpParam('username', false, ''));
        $group_id = intval($this->getHttpParam('group_id', false, 0));
        $pay = $this->getHttpParam('pay', false, '');
        $buy_num = intval($this->getHttpParam('buy_num', false, 0));
        $status = intval($this->getHttpParam('sub_type', false, 0));

        //保存会员基本信息
        $vip = $action == 'add' ? new Vips() : Vips::findOne(['id' => $mid]);
        $vip->username = $username;
        $vip->name = trim($this->getHttpParam('name', false, ''));
        $vip->contact = trim($this->getHttpParam('contact', false, ''));
        $vip->phone = intval($this->getHttpParam('phone', false, ''));
        $vip->group_id = $group_id;
        $vip->address = trim($this->getHttpParam('address', false, ''));
        $vip->pay = $pay;
        $vip->check_status = $status == 1 ? 1 : 0;
        $vip->inputer_id = Yii::$app->user->identity->uid;

        //保存会员权限
        $oldplg = VipPrivileges::find()
            ->where('username = :username', [':username' => $username])
            ->one();
        $vipGroup = Groups::findOne(['id' => $group_id]);
        $vipGroup = $vipGroup ? $vipGroup : Groups::findOne(1);
        $plg = ($action == 'add' || empty($oldplg)) ? new VipPrivileges() : $oldplg;
        $plg->username = $username;
        $plg->group_id = $group_id;
        $plg->buy_num = $buy_num;
        $plg->actual_pay = $pay;
        $plg->group_name = $vipGroup->name;
        $plg->shop_type = $vipGroup->shop_type;
        $plg->price = $vipGroup->price * $buy_num;
        $plg->business_push = $vipGroup->business_push * $buy_num;
        $plg->proj_num_lv1 = $vipGroup->proj_num_lv1 * $buy_num;
        $plg->proj_num_lv2 = $vipGroup->proj_num_lv2 * $buy_num;
        $plg->render_time = $vipGroup->render_time * $buy_num;
        $plg->proj_limit = $vipGroup->proj_limit * $buy_num;
        $plg->proj_user_limit = $vipGroup->proj_user_limit * $buy_num;
        $plg->studio_limit = $vipGroup->studio_limit * $buy_num;
        $plg->studio_user_limit = $vipGroup->studio_user_limit * $buy_num;
        $plg->updated_at = time();
        $plg->save();

        //保存会员状态信息
        $check = Check::find()
            ->where('username = :username', [':username' => $username])
            ->andWhere(['in', 'check_status', [0, 1, 2]])
            ->one();
        $check = $action == 'add' || !$check ? new Check() : $check;
        $check->username = $username;
        $check->checker_id = Yii::$app->user->identity->uid;
        $check->check_status = $status == 1 ? 1 : 0;
        $check->save();

        //保存OpportunityUser记录
        $opp = OpportunityUser::findOne(['username' => $username]);
        $opp = $opp ? $opp : new OpportunityUser();
        $opp->username = $username;
        $opp->created_at = time();
        $opp->save();

        if($vip->save()){
            $this->printSuccess();
        }
        else
        {
            $this->printError(['errors' => $vip->errors]);
        }

    }

    /**
     * 删除会员信息
     */
    public function actionDelete()
    {
        $ids = $this->getHttpParam('ids');
        if (empty($ids))
        {
            return;
        }
        $vips = Vips::findAll(['id' => $ids]);
        $usernames = ArrayHelper::getColumn($vips, 'username');
        //删除会员基本信息
        $del = Vips::deleteAll(['id' => $ids]);
        //删除会员等级信息
        VipPrivileges::deleteAll(['username' => $usernames]);
        //删除会员状态信息
        Check::deleteAll(['username' => $usernames]);
        if ($del)
        {
            $this->printSuccess();
        }
        else
        {
            $this->printError();
        }
    }

    /**
     * 编辑会员行业信息
     * @return json
     **/
    public function actionEditIndustries()
    {
        $username = trim($this->getHttpParam('u', false, ''));
        $plg = VipPrivileges::findOne(['username' => $username]);
        $industs = VipIndustries::find()->select(['ptype', 'stype'])->where(['username' => $username])->asArray()->all();
        $_data = [
            'industryJson' => Industry::getIndustryJson($industs),
            'username' => $plg ? $plg['username'] : '',
            'group_name' => $plg ? $plg['group_name'] : '',
            'proj_num_lv1' => $plg ? $plg['proj_num_lv1'] : 0,
            'proj_num_lv2' => $plg ? $plg['proj_num_lv2'] : 0,
        ];
        return $this->render('industries', $_data);

    }

    /**
     * 异步保存会员行业信息
     */
    public function actionAjaxSaveVipIndust()
    {
        $bool = true;
        $indarr = $this->getHttpParam('indarr', false, []);
        $username = trim($this->getHttpParam('username', false, ''));
        //删除原有的行业记录
        VipIndustries::deleteAll(['username' => $username]);
        foreach($indarr as $val){
            $ind = new VipIndustries();
            $ind->username = $username;
            $ind->ptype = $val['ptype'];
            $ind->stype = $val['stype'];
            $ind->old_ptype = $val['old_ptype'];
            $ind->old_stype = $val['old_stype'];
            $ind->create_at = time();
            $bool = $bool && $ind->save();
        }
        if ($bool)
        {
            $this->printSuccess();
        }
        else
        {
            $this->printError();
        }
    }

    /**
     * 异步加载会员等级信息
     */
    public function actionAjaxLoadGroupDetail()
    {
        $id = $this->getHttpParam('id', false, '0');
        if (empty($id))
        {
            $this->printError();
        }
        $model = new Groups();
        $record = $model->findOne(['id' => $id]);
        if ($record)
        {
            $this->printSuccess(['record' => $record]);
        }
        else
        {
            $this->printError();
        }
    }

    /**
     * 财务审核 对应于审核状态[1, 4]
     **/
    public function actionFinanceCheck()
    {
        $mid = intval($this->getHttpParam('id', false, 0));
        $vip = Vips::find()
            ->where('id = :mid', [':mid' => $mid])
            ->with('vipGroup')
            ->with('inputer')
            ->with('privileges')
            ->asArray()
            ->one();
        //基本信息
        $vip['input_time'] = date('Y-m-d H:i:s', $vip['created_at']);
        $vip['group_name'] = isset($vip['privileges']['group_name']) ? $vip['privileges']['group_name'] : '';
        $vip['price'] = isset($vip['vipGroup']['price']) ? $vip['vipGroup']['price'] : 0;
        $vip['buy_num'] = isset($vip['privileges']['buy_num']) ? $vip['privileges']['buy_num'] : 0;
        $vip['inputer_name'] = isset($vip['inputer']) ? $vip['inputer']['nickname'] : '';
        //审核状态信息
        $check = Vips::findOne(['id' => $mid])->getCheckStates($vip['check_status'])->one();
        $vip['serial_img'] = $check && $check->serial_img ? $check->serial_img : Yii::$app->params['no_found_pic'];
        $vip['serial_num'] = $check && $check->serial_num ? $check->serial_num : '';
        $vip['unpassed_reason'] = $check ? $check->unpassed_reason : '';

        //有效开始和截止时间等
        if(isset($vip['privileges'])){
            $valid_begin = $vip['privileges']['valid_begin'];
            $valid_end = strtotime('+'. $vip['privileges']['buy_num'] .' year', $valid_begin);
            $vip['valid_begin'] = $valid_begin > 0 ? date('Y-m-d H:i:s', $valid_begin) : '';
            $vip['valid_end'] = $valid_begin > 0 ? date('Y-m-d H:i:s', $valid_end) : '';
        }else{
            $vip['valid_begin'] = '';
            $vip['valid_end'] = '';
        }

        $_data = [
            'groups' => Groups::getGroupList(),
            'durations' => Groups::getDurationList(),
            'vip' => $vip,
        ];
        return $this->render('fincheck', $_data);
    }

    /**
     * 保存财务审核
     **/
    public function actionAjaxFinanceCheck(){
        $check_status = intval($this->getHttpParam('check_status', false, 2));//
        $new_status = intval($this->getHttpParam('sub_type', false, 2));//3-财务审核通过，运营审核待审核；2-财务审核驳回
        $username = trim($this->getHttpParam('username', false, ''));
        $serial_img = trim($this->getHttpParam('serial_img', false, ''));
        $serial_num = trim($this->getHttpParam('serial_num', false, ''));
        $unpassed_reason = trim($this->getHttpParam('unpassed_reason', false, ''));

        //保存会员状态信息
        $vip = Vips::find()->where('username = :username', [':username' => $username])->one();
        $vip->check_status = $new_status;
        $vip->save();

        $check = Check::find()
            ->where('username = :username', [':username' => $username])
            ->andWhere(['in', 'check_status', [2 ,3]])
            ->one();
        $check = !$check ? new Check() : $check;
        $check->username = $username;
        $check->checker_id = Yii::$app->user->identity->uid;
        $check->check_status = $new_status;
        $check->unpassed_reason = '';
        $check->serial_num = $serial_num;
        $check->serial_img = $serial_img;
        $check->unpassed_reason = $new_status == 2 ? $unpassed_reason : '';
        $check->updated_at = time();

        if ($check->save())
        {
            $this->printSuccess();
        }
        else
        {
            $this->printError();
        }
    }

    /**
     * 运营审核 对应于审核状态[3]
     */
    public function actionOperateCheck()
    {
        $mid = intval($this->getHttpParam('id', false, 0));
        $vip = Vips::find()
            ->where('id = :mid', [':mid' => $mid])
            ->with('vipGroup')
            ->with('inputer')
            ->with('privileges')
            ->asArray()
            ->one();
        //基本信息
        $vip['input_time'] = date('Y-m-d H:i:s', $vip['created_at']);
        $vip['group_name'] = isset($vip['privileges']['group_name']) ? $vip['privileges']['group_name'] : '';
        $vip['price'] = isset($vip['vipGroup']['price']) ? $vip['vipGroup']['price'] : 0;
        $vip['buy_num'] = isset($vip['privileges']['buy_num']) ? $vip['privileges']['buy_num'] : 0;
        $vip['inputer_name'] = isset($vip['inputer']) ? $vip['inputer']['nickname'] : '';

        //审核状态信息
        $check = Vips::findOne(['id' => $mid])->getCheckStates([3])->with('checker')->one();
        $vip['check_status'] = $check ? $check->check_status : '';
        $vip['serial_img'] = $check && $check->serial_img ? $check->serial_img : Yii::$app->params['no_found_pic'];
        $vip['serial_num'] = $check && $check->serial_num ? $check->serial_num : '';
        $vip['checker_name'] = $check && $check->checker ? $check->checker->nickname : '';
        $vip['unpassed_reason'] = $check ? $check->unpassed_reason : '';

        //有效开始和截止时间等
        if(isset($vip['privileges'])){
            $valid_begin = $vip['privileges']['valid_begin'];
            $valid_end = strtotime('+'. $vip['privileges']['buy_num'] .' year', $valid_begin);
            $vip['valid_begin'] = $valid_begin > 0 ? date('Y-m-d H:i:s', $valid_begin) : '';
            $vip['valid_end'] = $valid_begin > 0 ? date('Y-m-d H:i:s', $valid_end) : '';
        }else{
            $vip['valid_begin'] = '';
            $vip['valid_end'] = '';
        }

        $_data = [
            'groups' => Groups::getGroupList(),
            'durations' => Groups::getDurationList(),
            'vip' => $vip,
        ];
        return $this->render('oprcheck', $_data);
    }

    /**
     * 保存运营审核
     **/
    public function actionAjaxOperateCheck(){
        $check_status = intval($this->getHttpParam('check_status', false, 4));//原来状态
        $new_status = intval($this->getHttpParam('sub_type', false, 4));//5-运营审核通过；4-运营审核驳回
        $username = trim($this->getHttpParam('username', false, ''));
        $serial_img = trim($this->getHttpParam('serial_img', false, ''));
        $serial_num = trim($this->getHttpParam('serial_num', false, ''));
        $unpassed_reason = trim($this->getHttpParam('unpassed_reason', false, ''));
        //保存会员状态信息
        $vip = Vips::find()->where('username = :username', [':username' => $username])->one();
        $vip->check_status = $new_status;
        $vip->save();

        $check = Check::find()
            ->where('username = :username', [':username' => $username])
//            ->andWhere('check_status = :check_status', [':check_status' => $check_status])
            ->andWhere(['in', 'check_status', [4, 5]])
            ->one();
        $check = !$check ? new Check() : $check;
        $check->username = $username;
        $check->checker_id = Yii::$app->user->identity->uid;
        $check->check_status = $new_status;
        $check->unpassed_reason = '';
        $check->serial_num = $serial_num;
        $check->serial_img = $serial_img;
        $check->unpassed_reason = $new_status == 4 ? $unpassed_reason : '';
        $check->updated_at = time();

        //审核通过，则设定生效时间和失效时间
        if($new_status == 5){
            $plg = VipPrivileges::find()->where('username = :username', [':username' => $username])->one();
            if($plg){
                $plg->valid_begin = time();
                $plg->valid_end = strtotime('+'. $plg['buy_num'] .' year', time());
                $plg->save();
            }
        }
        if ($check->save())
        {
            $this->printSuccess();
        }
        else
        {
            $this->printError();
        }
    }


    /**
     * 添加流水编号
    **/
    public function actionAddSerialImg(){
        $workfile = isset($_GET['workfile']) ? urldecode($_GET['workfile']) : '';
        $action_to = yii::$app->request->get('action')? yii::$app->request->get('action') : 'setfileurlfromcallback';
        if ($workfile) {
            echo "<script>window.parent." . $action_to . "('$workfile');</script>";
            exit();
        }

    }

    /**
     * 异步校验用户名username是否合法
     * @return json
    **/
    public function actionAjaxCheckUser()
    {
        $username = trim($this->getHttpParam('username', false, ''));
        $vip = new Vips();
        $vip->username = $username;
        if($vip->validate()){
            $this->printSuccess();
        }
        else
        {
            $this->printError(['errors' => $vip->errors['username'][0]]);
        }

    }

    /**
     * 异步校验加载用户信息
     * @return json
    **/
    public function actionAjaxGetUserInfo()
    {
        $username = trim($this->getHttpParam('username', false, ''));
        $info = (new Vips())->getUserInfoByName($username);
        return $this->render('uinfo', ['info' => $info]);
    }


    /**
     * 获取审核状态信息
     */
    public function getCheckInfo($username, $status = 0)
    {
        $_text = '';
        $_status = -1;

        if($status == 0){
            $_text = '录入中';
            $_status = 0;
        }else if($status == 1){
            $_text = '财务待审核';
            $_status = 1;
        }else if($status == 2){
            $_text = '财务审核驳回';
            $_status = 2;
        }else if($status == 3){
            $_text = '运营待审核';
            $_status = 3;
        }else if($status == 4){
            $_text = '运营审核驳回';
            $_status = 4;
        }else if($status == 5){
            $_text = '运营审核通过';
            $_status = 5;
        }

        return [
            'checker_name' => '',
            'check_status' => $_text,
            'check_type' => $this->privilege,
        ];
//        $cheker = Check::find()
//            ->where(['username' => $username, 'check_status' => $_status])
//            ->with('checker')
//            ->one();
//        if ($cheker)
//        {
//            return [
////                'checker_name' => $cheker->checker ? $cheker->checker->nickname : '',
//                'checker_name' => '',
//                'check_status' => $_text,
//                'check_type' => $this->privilege,
//            ];
//        }
//        else
//        {
//            return [
//                'checker_name' => '',
//                'check_status' => '',
//                'check_type' => $this->privilege,
//            ];
//        }
    }
}