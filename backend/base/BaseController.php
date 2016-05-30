<?php

namespace app\base;

use yii;
use yii\web\Controller;
use yii\helpers\Json;
use common\lib\Tools;
use yii\filters\AccessControl;
use app\modules\team\models\Role;
use app\modules\team\models\Privilege;

class CommonWebController extends Controller
{
    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $actions = $this->limitActions();
        if (empty($actions))
        {
            return true;
        }
        else
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => $actions,
                            'allow' => true,
                            'matchCallback' => function ($rule, $action)
                            {
                                $prilist = Role::prilist();
                                $route = $this->module->id . '/' . $this->id . '/' . $this->action->id;
                                $privilege = Privilege::findOne(['route' => $route]);
                                $isSuperAdmin = false;
                                if (Yii::$app->user->identity->uid == 1 && Yii::$app->user->identity->role_id == 1)
                                {
                                    $isSuperAdmin = true;
                                }
                                //超级管理
                                if ($isSuperAdmin)
                                {
                                    return true;
                                }
                                //无权限配置或权限配置为空也是超管
                                elseif (empty($privilege) || !$prilist)
                                {
                                    return true;
                                }
                                elseif (!empty($privilege) && in_array($privilege->id, $prilist))
                                {
                                    return true;
                                }
                                else
                                {
                                    if (isset($_GET['ajax']))
                                    {
                                        $result = ['result' => false, 'message' => '对不起！权限错误或访问未授权！如有需要请联系管理员'];
                                        echo json_encode($result);
                                    }
                                    else
                                    {
                                        echo "对不起！访问未授权！如有需要请联系管理员";
                                    }
                                    die();
                                }
                            }
                        ]
                    ]
                ]
            ];
        }
    }

    /**
     * 返回，限制action数组，用于权限过滤，子类可以重写
     * @return array 限制actions数组
     */
    public function limitActions()
    {
        return [];
    }

    /**
     * 获取get或者post中的参数，默认先从get中取
     * @param $key 参数名
     * @param bool|true $required 必须字段 true的时候如果参数为空，将直接输出错误
     * @param null $default 默认值，在$required=false时生效
     * @return null
     */
    public function getHttpParam($key, $required = true, $default = null)
    {
        $p = isset($_GET[$key]) ? $_GET[$key] : (isset($_POST[$key]) ? $_POST[$key] : null);

        if ($required && $p === null)
        {
            $message = "missing param:$key";
            $this->printError($message);
        }
        if ($p === null)
        {
            $p = $default;
        }
        return $p;
    }

    public function isPost()
    {
        return \Yii::$app->request->isPost;
    }

    public function getYiiParam($key)
    {
        return \Yii::$app->params [$key];
    }

    public function getLoginUsername()
    {
        return \Yii::$app->user->getId();
    }

    public function printError($message = null, $code = null)
    {
        if ($message == null)
        {
            $message = \Yii::t('app', 'error');
        }
        $data = ["result" => false, "errorMessage" => $message, "code" => $code];
        $this->_echoJson($data);
    }

    public function printSuccess($data = [], $code = null, $message = '')
    {
        $data = array_merge(["result" => true, "code" => $code, 'message' => $message], $data);
        $this->_echoJson($data);
    }

    private function _echoJson($data)
    {
        // ie10以下不认识application/json
        //if (strpos($_SERVER ['HTTP_USER_AGENT'], "MSIE 8.0") || strpos($_SERVER ['HTTP_USER_AGENT'], "MSIE 9.0"))
        //{
        //    header('Content-Type:text/html;');
        //}
        echo Json::encode($data);
        exit;
    }

    /**
     * 判断是否是https请求
     * @return boolean
     */
    public static function isHttpsRequest()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on");
    }

    /**
     * 获取浏览器类型
     * @return string
     */
    public static function getBrowser()
    {
        $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11')) //ie11判断
        {
            return "ie";
        }
        else if (strpos($agent, 'Firefox') !== false)
        {
            return "firefox";
        }
        else if (strpos($agent, 'Chrome') !== false)
        {
            return "chrome";
        }
        else if (strpos($agent, 'Opera') !== false)
        {
            return 'opera';
        }
        else if ((strpos($agent, 'Chrome') == false) && strpos($agent, 'Safari') !== false)
        {
            return 'safari';
        }
        else
        {
            return 'unknown';
        }
    }

    /**
     * 转json
     * @param array $data
     * @return string
     */
    private function _to_json($data) {
        if (!empty($data)) {
            return json_encode($data);
        }
        return json_encode([]);
    }

    /**
     * 返回格式化数据转json
     * @param int $ret
     * @param string $msg
     * @param bool $data
     * @param bool $write_log
     * @return string
     */
    public function _return_json($ret, $msg = '', $data = null, $write_log = false) {
        @header('Content-Type:application/json;charset=utf-8');
        $r_data = [
            'ret' => $ret,
            'msg' => $msg,
            'data' => $data,
            'request_ip' => Tools::_get_ip(),
        ];

        if (empty($ret) && $ret != 0) {
            $r_data['ret'] = -40400;
        }

        if (empty($msg)) {
            unset($r_data['msg']);
        }

        if ($data === null) {
            unset($r_data['data']);
        }

        if ($write_log || $ret < 0) {//强制记录和状态异常时（小于 0）自动记录
            $this->_log_write($ret, $msg);
        }

        $_callback_fun_name = '';
        if (!empty($this->_request['jsonp'])) {
            $_callback_fun_name = $this->_request['jsonp'];
        }

        if (!empty($_callback_fun_name)) {
            exit($_callback_fun_name . '(' . $this->_to_json($r_data) . ');');
        }

        exit($this->_to_json($r_data));
    }

    /**
     * 获取Request参数
     * @param string $key
     * @param bool|array|string $default 当请求的参数不存在时的默认值
     * @return string
     */
    public function _request($key = '', $default = false) {
        $request = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
        if(empty($key)){
            return $request;
        }
        if(!isset($request[$key])){
            return $default;
        }
        return $request[$key];
    }

}

?>