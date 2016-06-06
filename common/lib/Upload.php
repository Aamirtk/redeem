<?php
namespace common\lib;

use Yii;

/**
 * 上传图片类
 *
 */
class Upload
{
    /**
     * 上传图片，默认路径为/frontend/web/upload/
     * @para string $temp 相对于/frontend/web/upload/的子目录
     * @return string 返回相对于/frontend/web/的图片路径
     *
     */
    function upload($path, $objtype = 'user')
    {
        $file = $_FILES['attachment'];

        //允许上传的 文件类型
        $type = array("jpg", "gif", "bmp", "jpeg", "png", "doc", "docx", "pdf", "txt");
        $filetype = substr(strrchr($file['name'], '.'), 1); //扩展名
        $filename = $file['name'];//原文件名

        $filePath =  $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . rtrim($path, '/') . DIRECTORY_SEPARATOR . $objtype . DIRECTORY_SEPARATOR . $this->_gen_dir();
        $fileName = $this->_gen_img_name($objtype) . '.' . $filetype; //新文件名

        if (!in_array(strtolower($filetype), $type)) {
            $text = implode(",", $type);
            $result = array(
                'code' => 407,
                'uploaded' => FALSE,
                'message' => "您只能上传以下类型文件: ,$text,");
            return $result;
        }
        if (!is_dir($filePath)) {
            @mkdir($filePath, 0777, true);
        }

        if (@move_uploaded_file($file['tmp_name'], $filePath . $fileName)) {
            $result = array(
                'code' => 200,
                'uploaded' => TRUE,
                'message' => '上传成功',
                'fileName' => $fileName, //file现在的名称
                'orgname' => $filename,//file原来的名称
                'filePath' => $filePath,
                'fileDir' => $path . $fileName,
                'url' => 'http://' . $_SERVER['SERVER_NAME'] . $path . $fileName
            );
            return $result;
        } else {
            $result = array(
                'code' => 207,
                'uploaded' => FALSE,
                'message' => '上传失败');
            return $result;
        }
    }

    /**
     * 生成图片名称
     * @return string
     */
    protected function _gen_img_name($objtype) {
        return md5(microtime() . $objtype . rand(0, 10000));
    }

    /**
     * 生成图片路径
     * @return string
     */
    protected function _gen_dir() {
        return DIRECTORY_SEPARATOR . date('Y', time()) . DIRECTORY_SEPARATOR . date('m', time()). DIRECTORY_SEPARATOR . date('d', time()) . DIRECTORY_SEPARATOR;
    }

}
?>