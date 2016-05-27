<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mark}}".
 *
 * @property integer $mark_id
 * @property string $model_code
 * @property integer $origin_id
 * @property integer $obj_id
 * @property double $obj_cash
 * @property integer $mark_status
 * @property string $mark_content
 * @property integer $mark_time
 * @property integer $uid
 * @property string $username
 * @property integer $mark_max_time
 * @property integer $by_uid
 * @property string $by_username
 * @property string $aid
 * @property string $aid_star
 * @property double $mark_value
 * @property integer $mark_type
 * @property integer $order_id
 */
class KekeWitkeyMark extends \yii\db\ActiveRecord
{
    const MARK_TYPE_BUYER = 1;  // 买家
    const MARK_TYPE_SELLER = 2; // 卖家

    const MODEL_CODE_SREWARD = 'sreward';   // 单人悬赏
    const MODEL_CODE_PREWARD = 'preward';   // 计件悬赏
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mark}}';
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
            [['origin_id', 'obj_id', 'mark_status', 'mark_time', 'uid', 'mark_max_time', 'by_uid', 'mark_type', 'order_id'], 'integer'],
            [['obj_cash', 'mark_value'], 'number'],
            [['mark_content'], 'string'],
            [['model_code', 'username', 'by_username'], 'string', 'max' => 20],
            [['aid', 'aid_star'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mark_id' => '记录编号',
            'model_code' => '模型编号',
            'origin_id' => '源对象编号',
            'obj_id' => '对象编号',
            'obj_cash' => '对象金额',
            'mark_status' => '评价状态 (0为尚未评 1好 2中 3差) ',
            'mark_content' => '评价内容',
            'mark_time' => '评价时间',
            'uid' => '被评价者用户编号',
            'username' => '被评价者用户名',
            'mark_max_time' => '自动评论过期时间',
            'by_uid' => '评论者用户编号',
            'by_username' => '评论者用户名',
            'aid' => '评价项 (12,3=>对威客的评价项,4,5=>对雇主的评价项) ',
            'aid_star' => '对应评价项的评分',
            'mark_value' => '评分所得能力值或信誉值',
            'mark_type' => '评论者角色 (1任务发布者或买家 2为任务威客或卖家)',
            'order_id' => '订单编号',
        ];
    }
}
