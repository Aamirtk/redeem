<?php
namespace frontend\components\menu;

use yii;
use frontend\components\WechatComponent;

class MenuComponent extends  WechatComponent
{
    public function init()
    {
        parent::init();
    }
    /**
     * 获取当前的自定义菜单设置
     */
    public function get()
    {
        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=%s';
        $apiUrl = sprintf($apiUrl,parent::getAccessToken());
        $menuData = file_get_contents($apiUrl);
        return $menuData;
    }

    /**
     * 创建自定义菜单
     * @param $menuJson string 菜单配置json字符串
     * @return mixed
     */
    public function create($menuJson)
    {
        $apiUrl = ' https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s';
        $apiUrl = sprintf($apiUrl,parent::getAccessToken());

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . parent::getAccessToken());
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $menuJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }

    /**
     * 删除自定义菜单
     * @return mixed
     */
    public function delete()
    {
        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=%s';
        $apiUrl = sprintf($apiUrl,$this->getAccessToken());
        $deleteResult = file_get_contents($apiUrl);
        return $deleteResult;
    }
}