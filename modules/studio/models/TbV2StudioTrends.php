<?php
namespace frontend\modules\studio\models;

use yii;

/**
 * This is the model class for table "tb_v2_studio_trends".
 *
 * @property integer $id
 * @property integer $s_id
 * @property string $name
 * @property string $content
 * @property string $banner
 * @property string $type
 * @property integer $v_num
 * @property integer $c_num
 * @property integer $f_num
 * @property integer $create_time
 * @property string $images
 * @property string $videos
 * @property string $copyright
 * @property string $tag
 * @property string $cover_img
 */
class TbV2StudioTrends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_v2_studio_trends';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return yii::$app->get('db_cz');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['s_id'], 'required'],
            [['s_id', 'v_num', 'c_num', 'f_num', 'create_time'], 'integer'],
            [['content', 'type', 'copyright'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['banner', 'images', 'videos', 'tag', 'cover_img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            's_id' => '工作室编号',
            'name' => '标题',
            'content' => '内容',
            'banner' => '封面图',
            'type' => '动态类型,1为图片,2为视频,3为文本',
            'v_num' => '浏览数',
            'c_num' => '评论数',
            'f_num' => '点赞数',
            'create_time' => '创建时间',
            'images' => '图片文件路径',
            'videos' => '视频链接/视频文件路径',
            'copyright' => '1.禁止看大图,2.禁止右键,3.禁止商业使用,4.不限制,5.禁止右键和商业使用',
            'tag' => '标签',
            'cover_img' => '动态封面图片',
        ];
    }

    public function getStudio()
    {
        return $this->hasOne(TbV2Studio::className(),['s_id'=>'s_id']);
    }
}