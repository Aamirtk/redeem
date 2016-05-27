<?php

namespace backend\modules\vip\models;

use Yii;
use app\modules\team\models\Team;

/**
 * This is the model class for table "vso_vip_check".
 *
 * @property integer $id
 * @property string $username
 * @property integer $mid
 * @property integer $checker_id
 * @property integer $check_status
 * @property string $serial_num
 * @property string $serial_img
 * @property string $unpassed_reason
 * @property integer $created_at
 * @property integer $updated_at
 */
class Check extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_vip_check';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_uc');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'checker_id', 'check_status', 'created_at', 'updated_at'], 'integer'],
            [['unpassed_reason'], 'string'],
            [['updated_at'], 'required'],
            [['username', 'serial_num'], 'string', 'max' => 30],
            [['serial_img'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户注册ID',
            'mid' => '会员ID',
            'checker_id' => '审核人ID',
            'check_status' => '审核状态（0-录入中；1-财务管理员待审核；2-财务管理员审核驳回；3-运营管理员待审核；4-运营管理员审核驳回；5-运营管理员审核通过）',
            'serial_num' => '财务流水编号',
            'serial_img' => '财务流水编号截图',
            'unpassed_reason' => '审核不通过原因',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取录入人员信息
     * @return object
     */
    public function getChecker()
    {
        return $this->hasOne(Team::className(), ['uid' => 'checker_id']);
    }
}
