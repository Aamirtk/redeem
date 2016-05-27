<?php

namespace backend\modules\vip\models;

use Yii;

/**
 * This is the model class for table "vso_vip_privileges".
 *
 * @property integer $id
 * @property string $username
 * @property integer $group_id
 * @property string $group_name
 * @property string $price
 * @property string $actual_pay
 * @property integer $buy_num
 * @property integer $business_push
 * @property integer $shop_type
 * @property integer $proj_num_lv1
 * @property integer $proj_num_lv2
 * @property integer $render_time
 * @property integer $proj_limit
 * @property integer $proj_user_limit
 * @property integer $studio_limit
 * @property integer $studio_user_limit
 * @property integer $valid_begin
 * @property integer $valid_end
 * @property integer $created_at
 * @property integer $updated_at
 */
class VipPrivileges extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_vip_privileges';
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
            [['group_id', 'buy_num', 'business_push', 'shop_type', 'proj_num_lv1', 'proj_num_lv2', 'render_time', 'proj_limit', 'proj_user_limit', 'studio_limit', 'studio_user_limit', 'valid_begin', 'valid_end', 'created_at', 'updated_at'], 'integer'],
            [['price', 'actual_pay'], 'number'],
            [['username', 'group_name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'username' => '用户名',
            'group_id' => '会员类型ID',
            'group_name' => '会员类型名称',
            'price' => '会员服务费用单价（元/年）',
            'actual_pay' => '实际购买价格',
            'buy_num' => '购买年数',
            'business_push' => '商机推送（万元）',
            'shop_type' => '商铺类型1普通版 2高级版',
            'proj_num_lv1' => '可入驻一级类目数量上限',
            'proj_num_lv2' => '可入驻二级类目数量上限',
            'render_time' => '渲染时长上限（分钟）',
            'proj_limit' => '虚拟工作室项目数量上限',
            'proj_user_limit' => '虚拟工作室项目成员数量上限',
            'studio_limit' => '可加入虚拟工作室上限',
            'studio_user_limit' => '工作室人数上限',
            'valid_begin' => '会员生效时间',
            'valid_end' => '会员失效时间',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
