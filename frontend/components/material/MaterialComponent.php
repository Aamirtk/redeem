<?php
namespace frontend\components\material;

use frontend\modules\wechat\models\BwxMaterialImage;
use yii;
use frontend\components\WechatComponent;

class MaterialComponent extends WechatComponent
{
    public function init()
    {
        parent::init();
    }


    /**
     * 新增临时素材
     */
    public function addTempMaterial()
    {

    }

    /**
     * 新增常驻素材
     */
    public function addPermanentMaterial()
    {

    }

    /**
     * 获取临时素材
     */
    public function getTempMaterial()
    {

    }

    /**
     * 获取常驻素材
     */
    public function getPermanentMaterial($media_id,$type='image')
    {
        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=%s';
        $apiUrl = sprintf($apiUrl,parent::getAccessToken());
        $post = [];
        $post['media_id'] = $media_id;
        $apiReturn = yii::$app->curl->sendPost($apiUrl,json_encode($post));
        $returndata = null;
        switch($type)
        {
            case 'news':
                $returndata = json_decode($apiReturn);
                break;
            default:
                $filename = yii::$app->params['WECHAT_TEMP_FILE_PATH'].md5($media_id.time()).'.jpg';
                file_put_contents($filename,$apiReturn);
                $returndata = md5($media_id.time()).'.jpg';
                $materialImage =  new BwxMaterialImage();
                $materialImage->media_id = $media_id;
                $materialImage->name = $returndata;
                $materialImage->update_time = time();
                $materialImage->url = yii::$app->params['SITE_HOST'].'temp/'.$returndata;
                $materialImage->local_path = $filename;
                $materialImage->save();
                break;
        }
        return $returndata;
    }

    /**
     * 修改常驻素材
     */
    public function editPermanentMaterial()
    {

    }

    /**
     * 删除常驻素材
     */
    public function deletePermanentMaterial()
    {

    }

    /**
     * 获取素材总数
     */
    public function getMaterialCount()
    {
    }

    /**
     * 获取素材列表
     */
    public function getMaterials($type,$offset,$limit)
    {
        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=%s';
        $apiUrl = sprintf($apiUrl,parent::getAccessToken());
        $post = [];
        $post['type'] = $type;
        $postp['offset'] = $offset;
        $post['count'] = $limit;
        $apiReturn = yii::$app->curl->sendPost($apiUrl,json_encode($post));
        $materails = json_decode($apiReturn);
        return $materails;
    }
}