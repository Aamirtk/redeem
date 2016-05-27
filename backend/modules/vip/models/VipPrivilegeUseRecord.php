<?php

namespace backend\modules\vip\models;

use Yii;

/**
 * 会员特权使用记录
 * This is the model class for table "vso_vip_privilege_use_record".
 *
 * @property integer $id
 * @property string $username
 * @property integer $group_id
 * @property string $privilege
 * @property string $amount_used
 * @property integer $unit
 * @property string $remark
 * @property integer $created_at
 * @property integer $updated_at
 */
class VipPrivilegeUseRecord extends \yii\db\ActiveRecord
{
    const PRIVILEGE_BUSINESS_PUSH = 'business_push';    // 商机推送
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_vip_privilege_use_record';
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
            [['username'], 'required'],
            [['group_id', 'unit', 'created_at', 'updated_at'], 'integer'],
            [['amount_used'], 'number'],
            [['username'], 'string', 'max' => 30],
            [['privilege'], 'string', 'max' => 20],
            [['remark'], 'string', 'max' => 255],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'username' => '用户名',
            'group_id' => '会员类型ID',
            'privilege' => '特权Key（price=>会员服务费用单价，business_push=>商机推送，proj_num_lv1=>可入驻一级类目数量上限，proj_num_lv2=>可入驻二级类目数量上限，render_time=>渲染时长上限，proj_limit=>虚拟工作室项目数量上限，proj_user_limit=>虚拟工作室项目成员数量上限，studio_limit=>可加入虚拟工作室上限，studio_user_limit=>工作室人数上限）',
            'amount_used' => '使用数量',
            'unit' => '计价单位（0=>个，1=>元，2=>万元，3=>分钟，4=>人）',
            'remark' => '备注',
            'created_at' => '使用时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取会员特权服务列表
     * @return array
     */
    public static function getPrivilegeArr()
    {
        $list = [
            'price' => '会员服务费用单价',
            'business_push' => '商机推送',
            'proj_num_lv1' => '可入驻一级类目数量上限',
            'proj_num_lv2' => '可入驻二级类目数量上限',
            'render_time' => '渲染时长上限',
            'proj_limit' => '虚拟工作室项目数量上限',
            'proj_user_limit' => '虚拟工作室项目成员数量上限',
            'studio_limit' => '可加入虚拟工作室上限',
            'studio_user_limit' => '工作室人数上限'
        ];
        return $list;
    }

    /**
     * 根据key值获取会员特权名称
     * @param string $key 权限key
     * @return string
     */
    public static function getPrivilegeNameByKey($key)
    {
        if (empty($key))
        {
            return '';
        }
        $list = self::getPrivilegeArr();
        return isset($list[$key]) ? $list[$key] : '';
    }

    /**
     * 获取会员权限计价单位列表
     * @return array
     */
    public static function getUnitArr()
    {
        $list = ['个', '元', '万元', '分钟'];
        return $list;
    }

    /**
     * 根据单位下标获取对应的翻译
     * @param integer $index 单位下标
     * @return string
     */
    public static function getUnitNameByIndex($index)
    {
        $list = self::getUnitArr();
        return isset($list[$index]) ? $list[$index] : '';
    }
}
