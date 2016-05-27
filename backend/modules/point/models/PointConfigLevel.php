<?php

namespace backend\modules\point\models;

use backend\modules\user\models\VsoUserExt;
use Yii;

/**
 * This is the model class for table "vso_point_config_level".
 *
 * @property integer $level_id
 * @property integer $level
 * @property integer $requirement
 * @property string $level_desc
 * @property integer $created_at
 * @property integer $updated_at
 */
class PointConfigLevel extends \yii\db\ActiveRecord
{
    const LEVEL_TOP_TRUST = 30; // 成长等级最大值，用于用户信用体系
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_point_config_level';
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
            [['level'], 'required'],
            [['level', 'requirement', 'created_at', 'updated_at'], 'integer'],
            [['level_desc'], 'string', 'max' => 10],
            [['created_at'], 'default', 'value' => time()],
            [['updated_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => '等级ID',
            'level' => '等级',
            'requirement' => '升级该等级所需的经验值条件',
            'level_desc' => '等级名称，比如vip1，lv1',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取对应等级所需要的积分值
     * @param $level 等级
     * @return int 积分值
     */
    public static function getPointByLevel($level)
    {
        if (empty($level))
        {
            return 0;
        }
        $point = self::find()
            ->select('requirement')
            ->where(['level' => $level])
            ->scalar();
        return intval($point);
    }

    /**
     * 获取用户升等之后的等级
     * 根据用户的积分值获取应该处于哪个等级，用于用户升等
     * @param $point 用户积分值
     * @return int 用户升等之后的等级
     */
    public static function getLevelByPoint($point)
    {
        if (empty($point))
        {
            return 0;
        }
        $level = self::find()
            ->select("MAX(`level`)")
            ->where(['<=', 'requirement', $point])
            ->scalar();
        return intval($level);
    }

    /**
     * 重新计算用户的积分等级
     * 用户筛选条件：积分值大于0
     */
    public static function reCalculateUserPointLevel()
    {
        $userExtTableName = VsoUserExt::tableName();
        $pointConfigLevelTableName = self::tableName();
        $sql = "UPDATE {$userExtTableName} ue
              SET point_level = (SELECT MAX(`level`) FROM {$pointConfigLevelTableName} WHERE requirement <= ue.point)
              WHERE point > 0";
        self::getDb()->createCommand($sql)->execute();
    }
}
