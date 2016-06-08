<?php
namespace backend\modules\common\controllers;

use Yii;
use common\lib\Upload;
use app\base\BaseController;

/**
 * Upload controller
 */
class UploadController extends BaseController
{
    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [ 'upload',];
    }

    /**
     * 上传图片
     * @return array
     */
    public function actionUpload() {
        $objtype = trim($this->_request('objtype', 'true'));

        $up_mdl = new Upload();
        $ret = $up_mdl->upload(yiiParams('img_save_dir'), $objtype);
        if ($ret['code'] > 0) {
            $this->_json(20000, $ret['msg'], $ret['data']);
        } else {
            $this->_json(-20000, $ret['msg']);
        }
    }

}
