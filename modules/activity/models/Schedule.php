<?php

namespace frontend\modules\activity\models;

use common\models\CommonSchedule;
use Yii;

class Schedule extends CommonSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'icon'], 'required', 'message'=>'不能为空'],
            [['start_time'], 'safe'],
            [['create_time', 'order'], 'integer'],
            [['create_time'], 'default', 'value' => time()],
            [['status', 'type'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['icon'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => self::STATUS_COMING],
            [['type'], 'default', 'value' => self::TYPE_START],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'title' => '活动名称',
            'icon' => 'logo图',
            'start_time' => '日期时间',
            'create_time' => '创建时间',
            'status' => '状态',
            'order' => '顺序',
            'type' => '阶段',
        ];
    }

}
