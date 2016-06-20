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
    private $_appId = 'wx4a7032faa3c317cb';
    private $_appSecret = '38bf39dc2782fc66e98e829101464d17';
    private $_token = 're123de456m';
    private $_encodingAesKey = 'dDzF33LN5z5K0FHHfb4AgcbhssEMM6EMhGNr3oENVx9';
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
