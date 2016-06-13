<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/2/15
 * Time: 11:03
 */
namespace frontend\modules\studio\controllers;

use common\api\Http;
use frontend\modules\personal\models\Person;
use frontend\modules\studio\models\TbV2StudioTrends;
use frontend\modules\studio\models\TbV2StudioTrendsComment;
use frontend\modules\studio\models\TbV2StudioTrendsFavorite;
use frontend\modules\talent\models\User;
use yii;
use yii\web\Controller;

class TrendsController extends Controller {

    public $enableCsrfValidation = false;

    //工作室列表页面
    public function actionList() {
        //获取参数
        $s_id = yii::$app->request->get('s_id');

        if (!$s_id) {
            return json_encode(['result' => false]);
        }
        $_http_mdl = new Http();
        $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioTrendsList'], ['s_id' => $s_id,'page'=>yii::$app->request->get('page'),'limit'=>yii::$app->request->get('limit')]));
        for($i = 0;$i<count($res['data']['_items']);$i++)
        {
            $tre = $res['data']['_items'][$i];
            $res['data']['_items'][$i]['create_time'] = date('Y-m-d',$tre['create_time']);
        }
        if ($res && $res['ret'] == 20001) {
            return json_encode(['result' => true, 'data' => $res['data']]);
        }
        else {
            return json_encode(['result' => false]);
        }
    }

    /**
     * 指定动态信息详情页面
     * @return mixed
     */
    public function actionDetail() {
        $id = yii::$app->request->get('id');
        $username = User::getLoginedUsername();
        $_http_mdl = new Http();
        //获取行业列表
        $trends = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioTrendsView'], ['id' => $id]));
        if ($trends['ret'] != 20001) {
            // 跳转走
        }
        $studio = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioInfo'], ['s_id' => $trends['data']['s_id'], 'username' => $username]));
        $fav = $favModel = TbV2StudioTrendsFavorite::find()->where(['username'=>$username,'trends_id'=>$id])->one();

        //获取评论
        $comments = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioTrendsCommentList'], ['t_id' => $id]));
        $otherTrends = $res = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioTrendsList'], ['s_id' => $trends['data']['s_id'],'page'=>yii::$app->request->get('page'),'limit'=>yii::$app->request->get('limit')]));

        for($i=0;$i<count($otherTrends['data']['_items']);$i++)
        {
            if($otherTrends['data']['_items'][$i]['id'] == $id)
            {
                unset($otherTrends['data']['_items'][$i]);
                break;
            }
        }
        $data = [
            'username' => $username,
            'nickname' => Person::getNickName($username),
            '_trends' => $trends['data'],
            '_studio' => $studio['data'],
            '_fav'=>$fav == null,
            '_comment'=>$comments['data'],
            '_others'=>$otherTrends['data']
        ];
        return $this->render('detail', $data);
    }

    /**
     * 发布图片动态信息
     * @return yii\web\Response
     */
    public function actionUploadImage()
    {
        $studioId = yii::$app->request->post('s_id');
        $tags = yii::$app->request->post('tags');
        $username = User::getLoginedUsername();
        $_http_mdl = new Http();
        $studio = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioInfo'], ['s_id' => $studioId, 'username' => $username]));
        if($studio['data']['studio_owner'] == $username)
        {
            $images = yii::$app->request->post('images');
            //获取第一张图片进行缩放
            $originCover = $images[0];
            $cover = $this->_resizeImage($originCover);
            $cover = $this->_cutCover($cover);
            $title = yii::$app->request->post('title');
            $content = yii::$app->request->post('content');
            $pickorvideo = yii::$app->request->post('picorvideo');
            $copyright = yii::$app->request->post('copyright');
            $trends = new TbV2StudioTrends();
            $trends->s_id = $studioId;
            $trends->name = $title;
            $trends->content = $content;
            $trends->type = $pickorvideo;
            $trends->banner = $images[0];
            $trends->create_time = time();
            $trends->copyright = $copyright ? $copyright : '4';
            $trends->images= $images ? json_encode($images) : '';
            $trends->tag =  $tags ? json_encode($tags) : '';
            $trends->cover_img = $cover;
            $trends->save();
            return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$studioId);
        }
        else
        {
            return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$studioId);
        }
    }

    /**
     * 等比例缩放图片
     * @param $imgName
     * @return bool|string
     */
    private function _resizeImage($imgName)
    {
        $fileNameArray = explode('/',$imgName);
        $fileNameArray2 = explode('.',$fileNameArray[count($fileNameArray)-1]);
        $fileName = $fileNameArray2[count($fileNameArray2)-2];
        $size = getimagesize(yii::$app->params['frontendurl'].$imgName);
        $width = $size[0];
        $height = $size[1];
        $targetWidth = yii::$app->params['trends_cover_width'];
        $targetHeight =  yii::$app->params['trends_cover_height'];

        $inputStream = file_get_contents(yii::$app->params['frontendurl'].$imgName);
        $originImgObject = imagecreatefromstring($inputStream);

        $coverImg = null;
        $scals = 1;//缩放比例
        $resizeResult = false;

        //超宽,按照宽度等比例缩放
        if($width > $targetWidth)
        {
            $scals = $targetWidth/$width;
            //计算缩放比例
            $coverImg =  imagecreatetruecolor (intval($targetWidth) , intval($height*$scals));
            $resizeResult = imagecopyresampled($coverImg, $originImgObject, 0, 0, 0, 0, intval($targetWidth),intval($height*$scals), $width, $height);
        }
        else if($height > $targetHeight)
        {
            $scals = $targetHeight/$height;
            //按照高度等比例缩放
            $coverImg =  imagecreatetruecolor (intval($scals*$width) , intval($targetHeight));
            $resizeResult = imagecopyresampled($coverImg, $originImgObject, 0, 0, 0, 0, intval($scals*$width),intval($targetHeight), $width, $height);
        }
        else
        {
            return $imgName;
        }
        if($resizeResult)
        {
            $random = md5($fileName.'resize'.time());
            $outResult = imagejpeg ($coverImg,yii::$app->params['trend_file_upload_path'].'/'.$random.'_resize.jpg');
            return $outResult?'/webuploader/upload/'.$random.'_resize.jpg':false;
        }
    }

    /**
     * 图片裁切
     * @param $imgName
     * @return bool|string
     */
    private function _cutCover($imgName)
    {
        $fileNameArray = explode('/',$imgName);
        $fileNameArray2 = explode('.',$fileNameArray[count($fileNameArray)-1]);
        $fileName = $fileNameArray2[count($fileNameArray2)-2];
        $size = getimagesize(yii::$app->params['frontendurl'].$imgName);
        $width = $size[0];
        $height = $size[1];
        $targetWidth = yii::$app->params['trends_cover_width'];
        $targetHeight =  yii::$app->params['trends_cover_height'];

        //创建目标尺寸的图片对象
        $coverImg = imagecreatetruecolor(intval($targetWidth) , intval($targetHeight));
        imagefilledrectangle ($coverImg ,0 ,0,intval($targetWidth) ,intval($targetHeight),0xFFFFFF);
        $inputStream = file_get_contents(yii::$app->params['frontendurl'].$imgName);
        $originImgObject = imagecreatefromstring($inputStream);
        //不存在宽度超标的可能,只存在高度超标
        if($height > $targetHeight)
        {
            $pointY = intval(($height-$targetHeight)/2);
            $cutResult =  imagecopyresampled ($coverImg , $originImgObject , 0, 0 ,0, $pointY ,$targetWidth , $targetHeight , $targetWidth, $targetHeight);
            if($cutResult){
                $random = md5($fileName.'cut'.time());
                $outResult = imagejpeg ($coverImg,yii::$app->params['trend_file_upload_path'].'/'.$random.'_cover.jpg');
                return $outResult?yii::$app->params['frontendurl'].'/webuploader/upload/'.$random.'_cover.jpg':false;
            }
        }
        else
        {
            return yii::$app->params['frontendurl'].$imgName;
        }
    }

    /**
     * 发布视频动态信息
     * @return yii\web\Response
     */
    public function actionUploadVideo()
    {
        $studioId = yii::$app->request->post('s_id');
        $tags = yii::$app->request->post('tags');
        $username = User::getLoginedUsername();
        $_http_mdl = new Http();
        $studio = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioInfo'], ['s_id' => $studioId, 'username' => $username]));
        if($studio['data']['studio_owner'] == $username)
        {
            $images = yii::$app->request->post('video_cover');
            $title = yii::$app->request->post('title');
            $content = yii::$app->request->post('content');
            $pickorvideo = yii::$app->request->post('picorvideo');
            $videoLink = yii::$app->request->post('link');
            $videos = yii::$app->request->post('videos');
            $copyright = yii::$app->request->post('copyright');
            $trends = new TbV2StudioTrends();
            $trends->s_id = $studioId;
            $trends->name = $title;
            $trends->content = $content;
            $trends->type = $pickorvideo;
            $trends->banner = $images;
            $trends->create_time = time();
            $trends->copyright = $copyright ? $copyright:'4';
            $trends->videos = $videos ? json_encode(['video'=>$videos]) :json_encode(['link'=>$videoLink]);
            $trends->tag = $tags ? json_encode($tags) : '';
            $trends->save();
            return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$studioId);
        }
        else
        {
            return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$studioId);
        }
    }

    /**
     * 发布文字动态信息
     * @return yii\web\Response
     */
    public function actionUploadText()
    {
        $studioId = yii::$app->request->post('s_id');
        $tags = yii::$app->request->post('tags');
        $username = User::getLoginedUsername();
        $_http_mdl = new Http();
        $studio = $this->_json_to_arr($_http_mdl->_get(yii::$app->params['czStudioInfo'], ['s_id' => $studioId, 'username' => $username]));
        if($studio['data']['studio_owner'] == $username)
        {
            $title = yii::$app->request->post('title');
            $content = yii::$app->request->post('content');
            $copyright = yii::$app->request->post('copyright');
            $trends = new TbV2StudioTrends();
            $trends->s_id = $studioId;
            $trends->name = $title;
            $trends->content = $content;
            $trends->create_time = time();
            $trends->copyright = $copyright ? $copyright : '4';
            $trends->tag = $tags ? json_encode($tags) : '';
            $trends->save();
            return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$studioId);
        }
        else
        {
            return $this->redirect(yii::$app->params['frontendurl'].'/studio/index/detail?s_id='.$studioId);
        }
    }

    /**
     * 点赞
     */
    public function actionFavor()
    {
        $username = $username = User::getLoginedUsername();
        $trends_id = yii::$app->request->post('t_id');
        $favModel = TbV2StudioTrendsFavorite::find()->where(['username'=>$username,'trends_id'=>$trends_id])->one();
        $f_num = TbV2StudioTrendsFavorite::find()->where(['trends_id'=>$trends_id])->count();
        if($favModel)
        {
            return json_encode(['fav_res'=>false,'message'=>'请勿重复点赞','f_num'=>$f_num]);
        }
        else
        {
            $favModel = new TbV2StudioTrendsFavorite();
            $favModel->username = $username;
            $favModel->trends_id = $trends_id;
            $saveResult = $favModel->save();
            if($saveResult)
            {
                $trendModel = TbV2StudioTrends::find()->where(['id'=>$trends_id])->one();
                $trendModel->f_num = $f_num+1;
                $trendModel->update();
                return json_encode(['fav_res'=>true,'message'=>'','f_num'=>$f_num+1]);
            }
            else
            {
                return json_encode(['fav_res'=>false,'message'=>'点赞失败','f_num'=>$f_num]);
            }
        }
    }

    /**
     * 取消点赞
     */
    public function actionUnfavor()
    {
        $username = $username = User::getLoginedUsername();
        $trends_id = yii::$app->request->post('t_id');
        $favModel = TbV2StudioTrendsFavorite::find()->where(['username'=>$username,'trends_id'=>$trends_id])->one();
        $f_num = TbV2StudioTrendsFavorite::find()->where(['trends_id'=>$trends_id])->count();
        if($favModel)
        {
            $saveResult = $favModel->delete();
            if($saveResult)
            {
                $trendModel = TbV2StudioTrends::find()->where(['id'=>$trends_id])->one();
                $trendModel->f_num = $f_num-1;
                $trendModel->update();
                return json_encode(['unfav_res'=>true,'message'=>'','f_num'=>$f_num-1]);
            }
            else
            {
                return json_encode(['unfav_res'=>false,'message'=>'取消赞失败','f_num'=>$f_num]);
            }
        }
        else
        {
            return json_encode(['unfav_res'=>false,'message'=>'无效的点赞记录']);
        }
    }

    /**
     * 删除评论
     * @return mixed
     * @throws \Exception
     */
    public function actionDeleteComment()
    {
        $id = yii::$app->request->post('id');
        $comment = TbV2StudioTrendsComment::find()->where(['id'=>$id])->one();
        if($comment)
        {
            $deleteRes = $comment->delete();
            return json_encode(['res'=>$deleteRes,'message'=>'']);
        }
        else
        {
            return json_encode(['res'=>false,'message'=>'无效的id']);
        }
    }

    /**
     * 发表评论
     * @return string
     */
    public function actionAddComment()
    {
        $t_id = yii::$app->request->post('t_id');
        $content = yii::$app->request->post('content');
        $username = User::getLoginedUsername();
        $comment = new TbV2StudioTrendsComment();
        $comment->create_time = time();
        $comment->username = $username;
        $comment->content = $content;
        if(isset($t_id))
        {
            $comment->t_id = $t_id;
            $comment->p_id = null;
        }
        else
        {
            $p_id = yii::$app->request->post('p_id');
            $p_comment = TbV2StudioTrendsComment::findOne(['id' => $p_id]);
            if ($p_comment) {
                $comment->t_id = $p_comment->t_id;
            }
            $comment->p_id = $p_id;
        }
//        $saveRes = $comment->save();
        if($comment->save() && $comment->t_id)
        {
            $trend =  TbV2StudioTrends::find()->where(['id' => $comment->t_id])->one();
            $trend->c_num =  $trend->c_num + 1;
            $trend->update();
            return json_encode(['res'=>true,'message'=>'']);
        }
        else
        {
            return json_encode(['res'=>false,'message'=>'评论失败']);
        }
    }

    public function actionDeleteTrend()
    {
        $id = yii::$app->request->post('id');
        $username = $username = User::getLoginedUsername();
        $trends = TbV2StudioTrends::find()->where(['id'=>$id])->with('studio')->one();
        if($trends)
        {
            if($trends->studio->studio_owner == $username)
            {
                $deleteRes = $trends->delete();
                return json_encode(['ret'=>$deleteRes,'msg'=>$deleteRes?'success':'fail']);
            }
            else
            {
                return json_encode(['ret'=>false,'msg'=>'no permission']);
            }
        }
        else
        {
            return json_encode(['ret'=>false,'msg'=>'no such trends']);
        }
    }

    //json转数组
    private function _json_to_arr($json) {
        if (empty($json)) {
            return '';
        }
        return json_decode($json,true);
    }

}