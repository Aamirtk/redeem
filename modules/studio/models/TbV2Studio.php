<?php
namespace frontend\modules\studio\models;

use yii;

/**
 * This is the model class for table "tb_studio".
 *
 * @property string $studio_id
 * @property string $studio_name
 * @property string $studio_desc
 * @property string $studio_icon
 * @property string $studio_owner
 * @property integer $create_time
 * @property string $status
 * @property integer $s_id
 * @property string $intro
 * @property integer $f_num
 * @property integer $v_num
 * @property string $open_status
 * @property string $open_role
 * @property integer $publish_time
 */
class TbV2Studio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_studio';
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
            [['studio_id', 'studio_name'], 'required'],
            [['studio_desc', 'studio_icon', 'status', 'open_status', 'open_role'], 'string'],
            [['create_time', 'f_num', 'v_num', 'publish_time'], 'integer'],
            [['studio_id'], 'string', 'max' => 33],
            [['studio_name', 'studio_owner'], 'string', 'max' => 255],
            [['intro'], 'string', 'max' => 100],
            [['studio_id'], 'unique'],
            [['studio_owner'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'studio_id' => '工作室编号',
            'studio_name' => '工作室名',
            'studio_desc' => '工作室描述',
            'studio_icon' => '工作室图标URL',
            'studio_owner' => '工作室创建者',
            'create_time' => '创建时间',
            'status' => '工作室状态；1=正常；2=禁用',
            's_id' => '工作室ID',
            'intro' => '一句话广告',
            'f_num' => '关注数',
            'v_num' => '浏览数',
            'open_status' => '开放状态1公开,2私有',
            'open_role' => '开放的角色,1所有人,2粉丝,3成员',
            'publish_time' => '成立时间',
        ];
    }

    public function getCats(){
        return $this->hasMany(TbV2StudioFromCategory::className(),['s_id'=>'s_id'])->with('cat');
    }
} 