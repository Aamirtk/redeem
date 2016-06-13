<?php

namespace frontend\modules\project\models;

use Yii;

/**
 * This is the model class for table "{{%proj_ext}}".
 *
 * @property integer $id
 * @property integer $proj_id
 * @property string $proj_banner
 * @property string $proj_desc
 * @property string $team_desc
 * @property string $remarks
 * @property string $proj_risk
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $img_str
 * @property string $qa_str
 */
class ProjExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%proj_ext}}';
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
            [['proj_id', 'proj_desc', 'team_desc', 'remarks', 'proj_risk', 'img_str', 'qa_str'], 'required'],
            [['proj_id', 'created_at', 'updated_at'], 'integer'],
            [['proj_desc', 'team_desc', 'remarks', 'proj_risk', 'img_str', 'qa_str'], 'string'],
            [['proj_banner'], 'string', 'max' => 255],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proj_id' => '项目编号',
            'proj_banner' => 'banner图',
            'proj_desc' => '项目介绍',
            'team_desc' => '团队介绍',
            'remarks' => '入驻原因',
            'proj_risk' => '项目风险',
            'created_at' => '创建时间',
            'updated_at' => '最后修改时间',
            'img_str' => '项目展示',
            'qa_str' => '疑问解答',
        ];
    }
}
