<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/2/29
 * Time: 19:13
 */

namespace common\lib;

use common\utils\WechatApp;
use yii;

class Wechat
{
    private $_appId = 'wx9462dd181a56c284';
    private $_appSecret = '6a6d79adca5a20309e05350da253bdae';
    private $_token = 're123de456m';
    private $_encodingAesKey = 'je3CZxBIjjPhTpeAUubOXCG6aVqMnygAdwmX6NCyGa0';
    public  $wechat = null;

    public function __construct()
    {
        $options = [
            'token' => $this->_token, //填写你设定的key
            'appid' => $this->_appId,
            'appsecret' => $this->_appSecret,
            'encodingAesKey' => $this->_encodingAesKey,
        ];
        $this->wechat = new WechatApp($options);
    }

    /**
     * 检验signature
     * @return type
     */
    public function checkSignature()
    {
        $signature = _request('signature');
        $timestamp = _request('timestamp');
        $nonce = _request('nonce');
        $token = $this->_token;

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 检验signature
     * @return type
     */
    public function replyText()
    {
        $this->wechat->valid();


    }



}
