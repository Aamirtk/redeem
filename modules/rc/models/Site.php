<?php

namespace frontend\modules\rc\models;

use Yii;

/**
 * This is the model class for table "{{%site}}".
 *
 * @property integer $id
 * @property string $site_name
 * @property string $site_logo
 * @property string $seo_keywords
 * @property string $seo_desc
 * @property integer $site_type
 */
class Site extends \yii\db\ActiveRecord
{
    const REDIS_KEY_PREFIX = 'site_seo';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_maker');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_logo'], 'string'],
            [['id', 'site_type'], 'integer'],
            [['site_name'], 'string', 'max' => 100],
            [['seo_keywords'], 'string', 'max' => 60],
            [['seo_desc'], 'string', 'max' => 255],
            //[['site_name'], 'required', 'message' => '不能为空']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '',
            'site_name' => '网站名称',
            'site_logo' => '网站logo（创客空间：请上传两张图，头部383px*83px，尾部258px*56px ；百万大赛：222px*59px；人才库：190px*60px）',
            'seo_keywords' => 'SEO关键词',
            'seo_desc' => 'SEO描述',
            'site_type' => '网站类型',
        ];
    }

    /**
     * 获取对应网站的logo
     * @param int $site_type 类型（1=>百万大赛，2=>人才库，3=>人才库首页，4=>人才库个人，5=>创客空间）
     * @return string
     */
    public static function getSiteLogo($site_type = 5)
    {
        $logo = self::find()
            ->select('site_logo')
            ->where(['site_type' => $site_type])
            ->limit(1)
            ->asArray()
            ->scalar();
        return empty($logo) ? '' : $logo;
    }

    /**
     * 获取网站类型列表
     * @param null $type
     * @return array
     */
    public static function getSiteTypeArr($type = null)
    {
        $type_arr = [
            1 => '百万大赛',
            2 => '人才库',
            3 => '人才库首页',
            4 => '人才库个人',
            5 => '创客空间'
        ];
        if ($type !== null)
        {
            return $type_arr[$type];
        }
        return $type_arr;
    }

    /**
     * 获取网站seo配置，使用redis缓存
     * @param int $type
     * @return array|static
     */
    public static function getSiteSeo($type = 5)
    {
        $key = self::REDIS_KEY_PREFIX . $type;
        $site = json_decode(yii::$app->redis->get($key), true);
        if (1)
        {
            $site = self::find()
                ->where(['site_type' => $type])
                ->orderBy(['id' => SORT_DESC])
                ->limit(1)
                ->asArray()
                ->one();

            $defaultSite = [
                'site_name' => "创意空间-专注孵化文创项目-蓝海创意云在线创作平台",
                'seo_keywords' => '创意空间，项目，创作空间',
                'seo_desc' => '蓝海创意云,创客空间孵化文创项目，专业审批，严格要求，展示最优质、最具潜力的项目。创意云诚邀创意人才入驻，玩转创意活动，打造文创行业最火爆创意圈子',
                'site_logo' => '<p><img src="http://maker.vsochina.com/images/home/footer-logo3.jpg"  alt="创意空间" class="pull-left dsn-logo"/></p>'
            ];
            $site = empty($site) ? $defaultSite : $site;
//            yii::$app->redis->SETEX($key, yii::$app->params['redis_expire'], json_encode($site));
        }
        return $site;
    }

    /**
     * 删除对应类型的seo在redis中的缓存
     * @param $type
     */
    public static function deleteRedisSiteSeo($type)
    {
        yii::$app->redis->DEL(self::REDIS_KEY_PREFIX . $type);
    }
}
