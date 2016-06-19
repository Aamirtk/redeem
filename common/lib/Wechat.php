<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/2/29
 * Time: 19:13
 */

namespace common\lib;

use common\api\VsoApi;
use yii;

class Wechat {
    private $_appId = 'wxd67d44974fa6111c';
    private $_appSecret = 'f4793ce52883b15c9da1a11054929bc4';
    private $_token = 're123de456m';

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

}
