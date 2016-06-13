<?php
namespace frontend\components;

use yii;
use yii\base\Component;

class WechatComponent extends Component
{
    private $wechatAppId;
    private $wechatSecret;
    private $wechatAccessToken;

    public function init()
    {
        parent::init();
        $this->wechatAppId = yii::$app->params['WECHAT_APP_ID'];
        $this->wechatSecret = yii::$app->params['WECHAT_SECRET'];
        $this->wechatAccessToken = $this->getAccessToken();
    }

    public function getAccessToken()
    {
        $accessToken = yii::$app->redis->get("bwc:access_token");
        if (!$accessToken)
        {
            $apiUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
            $apiUrl = sprintf($apiUrl, $this->wechatAppId,  $this->wechatSecret);
            $response = file_get_contents($apiUrl);
            $responseJson = json_decode($response);
            $accessToken = $responseJson->access_token;
            yii::$app->redis->setex("wc:access_token", yii::$app->params['WECHAT_ACCESS_TOKEN_EXPIRE_TIME'], $accessToken);
        }
        return $accessToken;
    }

    /**
     * @return mixed
     */
    public function getWechatAccessToken()
    {
        return $this->wechatAccessToken;
    }
}