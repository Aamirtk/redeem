<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "{{%apps}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $username
 * @property string $name
 * @property string $app_url
 * @property string $version
 * @property integer $indus_id
 * @property string $img_url_cover
 * @property string $img_url
 * @property string $original_url
 * @property integer $price_type
 * @property integer $price
 * @property string $phone
 * @property string $qq
 * @property string $des
 * @property integer $status
 * @property integer $orderby
 * @property integer $isindex
 * @property integer $isrem
 * @property integer $create_time
 * @property integer $update_time
 */
class ArtApp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%apps}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_art');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'username', 'name', 'app_url'], 'required'],
            [
                [
                    'uid',
                    'indus_id',
                    'price_type',
                    'price',
                    'status',
                    'orderby',
                    'isindex',
                    'isrem',
                    'create_time',
                    'update_time'
                ],
                'integer'
            ],
            [['des'], 'string'],
            [
                ['username', 'name', 'app_url', 'version', 'img_url_cover', 'img_url', 'original_url'],
                'string',
                'max' => 255
            ],
            [['phone'], 'string', 'max' => 11],
            [['qq'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '应用id',
            'uid' => '发布人用户编号',
            'username' => 'Username',
            'name' => '应用名称',
            'app_url' => '软件存储地址',
            'version' => '软件版本',
            'indus_id' => '分类编号',
            'img_url_cover' => 'Img Url Cover',
            'img_url' => '封面地址',
            'original_url' => '原创证明',
            'price_type' => '0免费，1创意币，2人民币',
            'price' => '价格/小时，0免费',
            'phone' => '手机号码',
            'qq' => 'QQ号码',
            'des' => '描述',
            'status' => '软件状态-1审核失败，0已提交，1正在处理，2已发布',
            'orderby' => '设定排序',
            'isindex' => '是否首页',
            'isrem' => '是否推荐',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
