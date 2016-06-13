<?php
namespace frontend\modules\studio\models;

use yii;

/**
 * This is the model class for table "tb_v2_studio_trends_comment".
 *
 * @property integer $id
 * @property integer $t_id
 * @property string $content
 * @property string $username
 * @property integer $p_id
 * @property integer $create_time
 */
class TbV2StudioTrendsComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_v2_studio_trends_comment';
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
            [['t_id', 'p_id', 'create_time'], 'integer'],
            [['content'], 'string'],
            [['username'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            't_id' => '动态编号',
            'content' => '讨论内容',
            'username' => '发布者',
            'p_id' => '父讨论的id',
            'create_time' => '发布时间',
        ];
    }
} 