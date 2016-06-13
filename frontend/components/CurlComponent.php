<?php
namespace frontend\components;

use yii;
use yii\base\Component;

class CurlComponent extends Component
{
    public function sendPost($url, $post)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//成功时不返回true，只返回结果
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function sendGet($url, $data)
    {
        $params = http_build_query($data);
        $url .= '?' . $params;
        $curlReturn = file_get_contents($url);
        return json_decode($curlReturn);
    }

    public function sendHttpsPost($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//成功时不返回true，只返回结果
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;

    }

    public function sendHttpsGet()
    {

    }
}
