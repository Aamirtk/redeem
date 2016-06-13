<?php

namespace frontend\modules\work\models;

use Yii;

/**
 * This is the model class for table "keke_works_show".
 *
 * @property integer $work_id
 * @property string $username
 * @property integer $uid
 * @property string $work_url
 * @property string $work_name
 * @property integer $on_time
 * @property integer $display
 * @property integer $pic_or_video
 * @property integer $deleted
 * @property string $cover_url
 * @property string $work_link
 * @property string $cover_link
 * @property string $description
 * @property string $school
 * @property integer $likenum
 * @property integer $sharenum
 * @property integer $browsenum
 * @property integer $commentnum
 * @property integer $prizeflag
 * @property integer $wd_privacy
 * @property integer $wd_price_end
 * @property integer $wd_price_start
 * @property integer $wd_period_start
 * @property integer $wd_period_end
 * @property string $activity
 * @property integer $p_work_id
 */
class KekeWorksShow extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 1;
    const STATUS_NOT_DELETED = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'keke_works_show';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_keke');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'on_time', 'display', 'pic_or_video', 'deleted', 'likenum', 'sharenum', 'browsenum', 'commentnum', 'prizeflag', 'wd_privacy', 'wd_price_end', 'wd_price_start', 'wd_period_start', 'wd_period_end', 'p_work_id'], 'integer'],
            [['username', 'activity'], 'string', 'max' => 50],
            [['work_url', 'work_name', 'cover_url', 'work_link', 'cover_link', 'description', 'school'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'work_id' => 'Work ID',
            'username' => 'Username',
            'uid' => 'Uid',
            'work_url' => '作品地址',
            'work_name' => '作品名称',
            'on_time' => 'On Time',
            'display' => '首页展示 最多4个 1首页展示',
            'pic_or_video' => '图片或者视频默认1图片 2视频',
            'deleted' => '是否删除 0未删除 1删除',
            'cover_url' => 'Cover Url',
            'work_link' => 'Work Link',
            'cover_link' => 'Cover Link',
            'description' => '描述',
            'school' => '院校',
            'likenum' => '喜欢数',
            'sharenum' => '分享数',
            'browsenum' => '浏览数',
            'commentnum' => '评论条数',
            'prizeflag' => '0=>其他 1=>原创活动',
            'wd_privacy' => '0：不隐藏 1：隐藏报价',
            'wd_price_end' => '魔女地下城：报价区间最高',
            'wd_price_start' => '魔女地下城：报价区间开始',
            'wd_period_start' => '魔女地下城：作画周期开始',
            'wd_period_end' => '魔女地下城：作画周期结束',
            'activity' => '活动',
            'p_work_id' => '父任务编号',
        ];
    }

    /**
     * 获取人才的作品数量
     * @param $username 用户名称
     * @return int|string
     */
    public static function getUserWorkNum($username)
    {
        if (empty($username))
        {
            return 0;
        }
        $count = self::find()
            ->where(['username' => $username, 'deleted' => self::STATUS_NOT_DELETED])
            ->count();
        return $count;
    }
}
