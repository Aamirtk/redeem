<?php
namespace frontend\modules\personal\controllers;

use common\api\VsoApi;
use frontend\modules\personal\models\Person;
use frontend\modules\personal\models\Work;
use frontend\modules\personal\models\Worklist;
use frontend\modules\talent\models\User;
use frontend\modules\personal\models\Goods;
use common\models_shop\shop_category;
use yii;
use frontend\controllers\CommonController;

class WorkController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = 'default';
    public $obj_username = "";      // 被访问用户的用户名
    public $vso_uname = '';          // 当前登录用户
    public $is_self = false;        // 被访问用户是否是当前登录用户
    public $user_info = array();    // 被访问用户信息

    /**
     * 查看作品详情
     * @param $id 作品编号
     * @return string|yii\web\Response
     */
    public function actionView($id)
    {
        // 参数非法
        if (empty($id))
        {
            return $this->redirect(yii::$app->defaultRoute);
        }
        $username=Work::getWorkOwner($id);
        if($this->obj_username==yii::$app->params['rc_domain_prefix'])
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header('Location:http://'.$username.'.vsochina.com'.$_SERVER['REQUEST_URI']) ;
            exit;
        }
        elseif($this->obj_username!=$username)
        {
            @header('HTTP/1.1 301 Moved Permanently');
            header("Location: http://www.vsochina.com");
            exit;            
        }        
        $data = [
            'work_id' => $id,
            'user_info' => $this->user_info,
        ];

        if(isMobile())
        {
            $this->layout = FALSE;
            return $this->render('mdetail', $data);
        }
        $good = Goods::find()
            ->where(['goods_id' => $id])
            ->one();
        $_shop_category_mdl = (new shop_category());
        $_shop_list = $_shop_category_mdl->_get_info(["c_id" => $good['c_id']]);
        $tags = json_decode($good['tags']);
        $a_tags = "";
        $a_tags_d = "";
        $b_tags = "";
        $b_tags_d = "";
        if(!empty($tags[0])){
            $a_tags .= ",".$tags[0].",";
            $a_tags_d .= $tags[0]."素材,";
        }
        if(!empty($tags[1])){
            $b_tags .= $tags[1].",";
            $b_tags_d .= $tags[1]."模板,";
        }
        $typeName = "";
        if(!empty($_shop_list["name"])){
            $typeName .= $_shop_list["name"]."-";
        }
        $fileName = "资源";
        if(!empty($good['name'])){
            $fileName = $good["name"];
        }
        yii::$app->view->params['_page_config'] = [
            'title' => $fileName."下载-".$typeName."创意商城mall.vsochina.com",
            'keyword' => $fileName.$a_tags.$b_tags."原创创意作品",
            'description' => $fileName."作品下载,".$a_tags_d.$b_tags_d."原创创意".$fileName."作品下载.创意商城mall.vsochina.com有创意更懂你。",
        ];
        return $this->render('detail', $data);
    }

    /**
     * 发表评论，ajax请求，post
     * 走接口中心
     */
    public function actionCreateComment()
    {
        // 作品编号
        $work_id = yii::$app->request->post('work_id');
        if (empty($work_id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少作品编号']);
            exit;
        }
        // 评论内容
        $content = yii::$app->request->post('content');
        if (!isset($content))
        {
            echo json_encode(['result' => false, 'msg' => '缺少评论内容']);
            exit;
        }
        // 发布评论的用户
        $username = User::getLoginedUsername();
        // 被评论的用户
        $obj_username = Work::getWorkOwner($work_id);
        if (empty($username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        $url = "http://api.vsochina.com/comment/create";
        $data = [
            'username' => $username,
            'content' => $content,
            'objid' => $work_id,
            'originid' => $work_id,
            'objtype' => 'works',
            'pid' => intval(yii::$app->request->post('pid')),
            'leavetype' => 2
        ];
        $result = VsoApi::send($url, $data);
        if (isset($result['data']) && !empty($result['data']))
        {
            //设置作品读取Flag
            Person::setUserWorksFlag($obj_username, 2);

            echo json_encode(['result' => true, 'msg' => '评论成功', 'comment_id' => $result['data']['comment_id']]);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '评论失败']);
            exit;
        }
    }

    /**
     * 作品点赞or取消赞，ajax请求，post
     * @param $id 作品编号
     */
    public function actionPraise($id)
    {
        if (empty($id))
        {
            echo json_encode(['result' => false, 'msg' => '缺少作品编号']);
            exit;
        }
        // 发布评论的用户
        $username = User::getLoginedUsername();
        // 被评论的用户
        $obj_username = Work::getWorkOwner($id);
        if (empty($username))
        {
            echo json_encode(['result' => false, 'msg' => '登录后才能进行此操作']);
            exit;
        }
        $url = "http://api.vsochina.com/work/work/praise";
        $data = [
            'workid' => $id,
            'username' => $username,
            'status' => yii::$app->request->post('status')
        ];
        $curl_result = VsoApi::send($url, $data);
        if (isset($curl_result['ret']) && $curl_result['ret'] == 13600)
        {
            ///设置作品读取Flag
            Person::setUserWorksFlag($obj_username, 2);
            $data = $curl_result['data'];
            echo json_encode(['result' => true, 'msg' => '操作成功', 'data' => $data]);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '操作失败']);
            exit;
        }
    }

    /**
     * 加载作品详情
     * @param $id 作品编号
     * @return yii\web\Response
     */
    public function actionLoadWorkDetail($id)
    {
        // 参数非法
        if (empty($id))
        {
            return $this->redirect(yii::$app->defaultRoute);
        }
        // 作品不存在
        $work = Work::getWorkDetail($id);
        echo json_encode($work);
    }

    /**
     * 获取当前登录用户对作品的点赞状态
     * @param $id
     */
    public function actionLoadWorkPraiseStatus($id)
    {
        // 当前登录用户
        $result = ['praise_status' => '0', 'praise_title' => '点赞', 'praise_type' => '0',];
        $work = Work::getWorkDetail($id);
        $praise_type = isset($work['activity']) && $work['activity']=='railcontest' ? 1 : 0;
        $username = User::getLoginedUsername();
        if (empty($id) || ($praise_type==0 && empty($username)))
        {
            echo json_encode($result);
            exit;
        }

        $url = "http://api.vsochina.com/work/work/get-work-praise-status";
        $data = [
            'work_id' => $id,
            'username' => $username,
        ];
        $curl_result = VsoApi::send($url, $data, 'get');

        if (isset($curl_result['data']) && !empty($curl_result['data']))
        {
            $json = [
                'praise_status'=> $curl_result['data']['praise_status'],
                'praise_title'=> $curl_result['data']['praise_title'],
                'praise_type'=> $praise_type
            ];
            echo json_encode($json);
            exit;
        }
        else
        {
            echo json_encode($result);
            exit;
        }
    }

    /**
     * 加载作品评论
     * @param $id 作品编号
     * @return yii\web\Response
     */
    public function actionLoadCommentList($id)
    {
        // 参数非法
        if (empty($id))
        {
            return $this->redirect(yii::$app->defaultRoute);
        }
        $page = intval(yii::$app->request->get('page'));
        $page = max($page, 1);
        $limit = 10;//每页显示条数
        $offset = ($page - 1) * $limit;
        $comment = Work::getWorkCommentList($id, $offset, $limit);

        echo json_encode([
            'data' => $comment,
            '_now_page' => $page,
        ]);
    }

    /**
     * 删除评论
     */
    public function actionDeleteComment()
    {
        $comment_id = yii::$app->request->post('comment_id');
        $url = "http://api.vsochina.com/comment/delete-comment";
        $result = VsoApi::send($url, ['comment_id' => $comment_id]);
        if (isset($result['data']) && !empty($result['data']))
        {
            //设置作品读取Flag
            Person::setUserWorksFlag(User::getLoginedUsername(), 2);
            echo json_encode(['result' => true, 'msg' => '评论删除成功']);
            exit;
        }
        else
        {
            echo json_encode(['result' => false, 'msg' => '评论删除失败']);
            exit;
        }
    }

    /*
     * 作品上传
     * 接口中心
     */
    public function actionCreate()
    {
        $this->layout = false;
        //设置作品读取Flag
        Person::setUserWorksFlag(User::getLoginedUsername(), 2);

        if (yii::$app->request->isPost)
        {
            if (!$this->_check_login_status())//未登录
            {
                exit(json_encode(['ret' => '0002', 'msg' => '未登录！']));
            }
            $_get_data = yii::$app->request->post('work');
            $data = [
                'workname' => trim($_get_data['name']),
                'workcover' => '',
                'coverlink' => '',
                'workfile' => '',
                'worklink' => '',
                'workdescription' => empty($_get_data['content']) ? '' : $_get_data['content'],
                'p_work_id' => intval($_get_data['work_group_id']),//作品集ID
                'picorvideo' => intval($_get_data['picorvideo']),//作品类型
                'copyright' => intval($_get_data['open_status']),//版权字段
                'lable' => (!empty($_get_data['tags']) && is_array($_get_data['tags'])) ? join(
                    ',',
                    $_get_data['tags']
                ) : '',
                'username' => User::getLoginedUsername(),
                'appid' => 'rc',
                'token' => 'rc.vsochina.com',
            ];
            if (empty($data['workname']))
            {
                $data['workname'] = '未命名作品';
            }
            if (empty($data['picorvideo']) || !in_array($data['picorvideo'], [1, 2, 3]))
            {
                exit(json_encode(['ret' => '0003', 'msg' => '添加作品失败，未找到作品类型！']));
            }
            if ((empty($data['copyright']) && $data['copyright'] != 0) || !in_array(
                    $data['copyright'],
                    [0, 1, 2, 3, 4]
                )
            )
            {
                exit(json_encode(['ret' => '0004', 'msg' => '添加作品失败，版权类型设置不正确！']));
            }

            $_insert_data = [];
            switch ($data['picorvideo'])
            {
                case 1://图片
                    //获取图片列表
                    if (!empty($_get_data['pic_list']))
                    {
                        foreach ($_get_data['pic_list'] as $key => $val)
                        {
                            $_insert_data[$key] = $data;
                            $_insert_data[$key]['workfile'] = $val;
                            if (!empty($_get_data['work_desc'][$key]))
                            {
                                $_insert_data[$key]['workdescription'] = $_get_data['work_desc'][$key];
                            }
                            $_insert_data[$key]['alt'] = '';
                        }
                    }
                    break;
                case 2://视频
                    if (empty($_get_data['work_url']) && empty($_get_data['work_link']))
                    {
                        exit(json_encode(['ret' => '0005', 'msg' => '修改失败，未上传作品！']));
                    }

                    $_insert_data[0] = $data;
                    $_insert_data[0]['workcover'] = trim($_get_data['workcover']);
                    if (!empty($_get_data['work_link']))
                    {
                        $_insert_data[0]['worklink'] = trim($_get_data['work_link']);
                    }
                    else
                    {
                        $_insert_data[0]['workfile'] = trim($_get_data['work_url']);
                    }
                    break;
                case 3://文字
                    if (empty($data['workdescription']))
                    {
                        exit(json_encode(['ret' => '0006', 'msg' => '修改失败，详情为必填项！']));
                    }
                    $_insert_data[0] = $data;
                    break;
                default:
                    break;
            }

            if (empty($_insert_data))
            {
                exit(json_encode(['ret' => '0003', 'msg' => '添加作品失败，数据不完整！']));
            }
            if (!empty($_insert_data) && is_array($_insert_data))
            {
                $_add_result = [];
                foreach ($_insert_data as $val)
                {
                    $_add_result[] = Work::_add_work($val);
                }
                if (!in_array(false, $_add_result))//添加成功
                {
                    exit(json_encode(['ret' => '0001', 'msg' => '作品添加成功！']));
                }
            }
            exit(json_encode(['ret' => '0000', 'msg' => '作品添加失败！']));
        }
        else
        {
            if (!$this->_check_login_status())//未登录
            {
                return $this->redirect('http://account.vsochina.com/user/login');
//                exit('未登录!');
            }
            $_work_group_list = Worklist::getUserWorklist(User::getLoginedUsername());
            $data = [
                '_page_config' => [
                    'title' => '作品上传_会员中心_创意云人才库',
                ],
                '_work_group_list' => $_work_group_list,
                'username' => User::getLoginedUsername(),
                'user_info' => Person::getUserInfo(User::getLoginedUsername())
            ];
            return $this->render('create', $data);
        }
    }

    /*
     * 作品修改
     * 接口中心
     */
    public function actionUpdate()
    {
        $this->layout = false;

        if (yii::$app->request->isPost)
        {
            //设置作品读取Flag
            Person::setUserWorksFlag(User::getLoginedUsername(), 2);

            if (!$this->_check_login_status())//未登录
            {
                exit(json_encode(['ret' => '0002', 'msg' => '未登录！']));
            }

            $_get_data = yii::$app->request->post('work');
            $data = [
                'workid' => intval($_get_data['work_id']),
                'workname' => trim($_get_data['name']),
                'workcover' => '',
                'coverlink' => '',
                'workfile' => '',
                'worklink' => '',
                'workdescription' => empty($_get_data['content']) ? '' : $_get_data['content'],
                'p_work_id' => intval($_get_data['work_group_id']),//作品集ID
                'picorvideo' => intval($_get_data['picorvideo']),//作品类型
                'copyright' => intval($_get_data['open_status']),//版权字段
                'lable' => (!empty($_get_data['tags']) && is_array($_get_data['tags'])) ? join(
                    ',',
                    $_get_data['tags']
                ) : '',
                'username' => User::getLoginedUsername(),
                'appid' => 'rc',
                'token' => 'rc.vsochina.com',
            ];
            if (empty($data['workname']))
            {
                $data['workname'] = '未命名作品';
            }
            if (empty($data['picorvideo']) || !in_array($data['picorvideo'], [1, 2, 3]))
            {
                exit(json_encode(['ret' => '0003', 'msg' => '修改失败，未找到作品类型！']));
            }
            if ((empty($data['copyright']) && $data['copyright'] != 0) || !in_array(
                    $data['copyright'],
                    [0, 1, 2, 3, 4]
                )
            )
            {
                exit(json_encode(['ret' => '0004', 'msg' => '修改失败，版权类型设置不正确！']));
            }

            switch ($data['picorvideo'])
            {
                case 1://图片
                    if (empty($_get_data['workfile']))
                    {
                        exit(json_encode(['ret' => '0005', 'msg' => '修改失败，未上传作品！']));
                    }
                    $data['workfile'] = $_get_data['workfile'];
                    $_update_ret = Work::_update_work($data);
                    if ($_update_ret !== false)
                    {
                        exit(json_encode(['ret' => '0001', 'msg' => '修改成功！']));
                    }
                    break;
                case 2://视频
                    if (empty($_get_data['work_url']) && empty($_get_data['work_link']))
                    {
                        exit(json_encode(['ret' => '0005', 'msg' => '修改失败，未上传作品！']));
                    }

                    if (empty($_get_data['cover_url']))
                    {
                        exit(json_encode(['ret' => '0006', 'msg' => '修改失败，未上传作品封面！']));
                    }

                    if (!empty($_get_data['work_link']))
                    {
                        $data['worklink'] = $_get_data['work_link'];
                    }
                    else
                    {
                        $data['workfile'] = $_get_data['work_url'];
                    }

                    $data['workcover'] = $_get_data['cover_url'];
                    $_update_ret = Work::_update_work($data);
                    if ($_update_ret !== false)
                    {
                        exit(json_encode(['ret' => '0001', 'msg' => '修改成功！']));
                    }
                    break;
                case 3://文字
                    if (empty($data['workdescription']))
                    {
                        exit(json_encode(['ret' => '0006', 'msg' => '修改失败，详情为必填项！']));
                    }

                    $_update_ret = Work::_update_work($data);
                    if ($_update_ret !== false)
                    {
                        exit(json_encode(['ret' => '0001', 'msg' => '修改成功！']));
                    }
                    break;
                default:
                    break;
            }
            exit(json_encode(['ret' => '0000', 'msg' => '修改失败！']));
        }
        else
        {
            if (!$this->_check_login_status())//未登录
            {
                return $this->redirect('http://account.vsochina.com/user/login');
//                exit('未登录!');
            }

            $_work_id = yii::$app->request->get('w_id');
            if (empty($_work_id))
            {
                exit('未找到数据!');
            }

            //获取作品信息
            $_work_info = Work::_get_work($_work_id);
            if (empty($_work_info['data']))
            {
                exit('未找到作品数据!');
            }

            $_work_group_list = Worklist::getUserWorklist(User::getLoginedUsername());
            if (!empty($_work_group_list))
            {
                foreach ($_work_group_list as $val)
                {
                    $_group_list[$val['p_work_id']] = $val;
                }
            }
            $data = [
                '_page_config' => [
                    'title' => '作品上传_会员中心_创意云人才库',
                ],
                '_work_group_list' => $_group_list,
                'username' => User::getLoginedUsername(),
                '_work_info' => $_work_info['data'],
                '_work_id' => $_work_id,
                'user_info' => Person::getUserInfo(User::getLoginedUsername())
            ];
            return $this->render('update', $data);
        }
    }

    /*
     * 添加作品集
     * 接口中心
     */
    public function actionAjax_create_work_group()
    {
        if (!$this->_check_login_status())//未登录
        {
            exit(json_encode(
                [
                    'ret' => '0002',
                    'jump_url' => yii::$app->urlManager->createUrl(['personal/work/upload']),
                    'msg' => '未登录！'
                ]
            ));
        }

        $data = [
            'name' => yii::$app->request->post('name'),
            'username' => User::getLoginedUsername(),
            'cover' => '',
        ];
        if (empty($data['name']))
        {
            exit(json_encode(['ret' => '0002', 'msg' => '作品集名称不能为空！']));
        }
        $result = Worklist::createWorklist($data['username'], $data['name'], $data['cover']);
        if ($result['ret'] == '13640')
        {
            exit(json_encode(
                [
                    'ret' => '0001',
                    'data' => [
                        'name' => $data['name'],
                        'work_group_id' => $result['data']['worklistid'],
                    ],
                    'jump_url' => yii::$app->urlManager->createUrl(['personal/work/upload']),
                    'msg' => '成功！'
                ]
            ));
        }
        else
        {
            exit(json_encode(['ret' => '0000', 'msg' => '失败！']));
        }
    }

    /**
     * 轨交活动点赞功能
     */
    public function actionAjaxLike()
    {
        $workID = yii::$app->request->get('workid');
        $redis = yii::$app->redis;
        $redis->hincrby('activity.vsochina.com:railcontest:likes', $workID, 1);
        $like_num = $redis->hget('activity.vsochina.com:railcontest:likes', $workID);
        $data = ['like_num' => $like_num];
        echo json_encode($data);
        exit;

    }
    /**
     * 获取点赞功能
     */
    public function actionAjaxGetLike()
    {
        $workID = yii::$app->request->get('workid');
        if(empty($workID)){
            echo json_encode(['like_num' => 0]);
            exit;
        }
        $work = Work::getWorkDetail($workID);
        $praise_type = isset($work['activity']) && $work['activity']=='railcontest' ? 1 : 0;//是否为轨交活动
        if($praise_type==1){
            $redis = yii::$app->redis;
            $like_num = $redis->hget('activity.vsochina.com:railcontest:likes', $workID);
        }else{
            $like_num = $work['likenum'];
        }
        $like_num = empty($like_num) ? 0 : $like_num;
        $data = ['like_num' => $like_num];
        echo json_encode($data);
        exit;

    }

    /*
     * 判断用户登录状态
     * @return Bollean
     */
    private function _check_login_status()
    {
        $username = User::getLoginedUsername();
        if (empty($username))
        {
            return false;
        }
        return true;
    }
}