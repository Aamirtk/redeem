<?php

namespace backend\modules\opportunity\models;

use backend\modules\vip\models\VipPrivileges;
use backend\modules\vip\models\VipPrivilegeUseRecord;
use backend\modules\vip\models\Vips;
use Yii;

/**
 * This is the model class for table "vso_opportunity_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $recommend_cash
 * @property integer $recommend_count
 * @property integer $view_count
 * @property integer $contact_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class OpportunityUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_opportunity_user';
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
            [['recommend_cash'], 'number'],
            [['recommend_count', 'view_count', 'contact_count', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['username'], 'unique'],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户推送ID',
            'username' => '用户名',
            'recommend_cash' => '已推送金额',
            'recommend_count' => '推送条数',
            'view_count' => '已查看数量',
            'contact_count' => '已联系数量',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取会员权限
     * @return object
     */
    public function getPrivileges()
    {
        return $this->hasOne(VipPrivileges::className(), ['username' => 'username']);
    }

    /**
     * 金额格式化
     * @param float $cash 金额，单位元，两位小数
     * @return float 格式化后的金额，单位万元，保留一位小数
     */
    public static function cashFormat($cash)
    {
        return sprintf("%.1f", $cash / 10000);
    }

    /**
     * 检测用户接收商机推送的金额是否超过会员分类中的上限
     * 如果未超过上限，不做处理
     * 如果超过上限，向会员特权中插入记录
     * @param string $username 用户名
     */
    public static function checkRecommendCashOverflow($username)
    {
        if (empty($username))
        {
            return;
        }
        // 已推送给用户的商机金额，单位元
        $recommend_cash = self::find()
            ->select('recommend_cash')
            ->where(['username' => $username])
            ->scalar();
        // 金额格式化，单位万元
        $cash = self::cashFormat($recommend_cash);
        // 用户会员等级信息
        $userGroupInfo = Vips::find()
            ->with('vipGroup')
            ->where(['username' => $username])
            ->asArray()
            ->one();
        // 会员等级中推送金额上限，单位万元
        $cash_config = isset($userGroupInfo['vipGroup']) ? $userGroupInfo['vipGroup']['business_push'] : 0;
        // 超过上限
        if ($cash_config > 0 && $cash >= $cash_config)
        {
            $group_id = $userGroupInfo['group_id'];
            $model = VipPrivilegeUseRecord::find()
                ->where([
                    'username' => $username,
                    'group_id' => $group_id,
                    'privilege' => VipPrivilegeUseRecord::PRIVILEGE_BUSINESS_PUSH
                ])
                ->one();
            // 数据已存在，不做处理
            if (!empty($model))
            {
                return;
            }
            // 数据不存在，插入新数据
            $model = new VipPrivilegeUseRecord();
            $model->setAttributes([
                'username' => $username,
                'group_id' => $group_id,
                'privilege' => VipPrivilegeUseRecord::PRIVILEGE_BUSINESS_PUSH,
                'amount_used' => $recommend_cash,
                'unit' => 1
            ]);
            $model->save();
        }
    }
}
