<?php

namespace backend\modules\point\models;

use Yii;

/**
 * This is the model class for table "vso_point_config_rule".
 *
 * @property integer $rid
 * @property string $rulename
 * @property string $rulealias
 * @property integer $available
 * @property string $chid
 * @property string $action
 * @property integer $cycletype
 * @property integer $cycletime
 * @property integer $rewardnum
 * @property integer $point
 * @property integer $created_at
 * @property integer $updated_at
 */
class PointConfigRule extends \yii\db\ActiveRecord
{
    const RULE_ENABLED = 1;     // 规则启用
    const RULE_DISABLED = 0;    // 规则禁用
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_point_config_rule';
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
            [['rulealias'], 'required'],
            [['available', 'cycletype', 'cycletime', 'rewardnum', 'point', 'created_at', 'updated_at'], 'integer'],
            [['rulename', 'rulealias', 'chid', 'action'], 'string', 'max' => 20],
            [['action'], 'unique'],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => '规则ID',
            'rulename' => '规则名称（行为名称）',
            'rulealias' => '别名，描述行为用',
            'available' => '是否启用 0：不启用 1：启用',
            'chid' => '频道ID',
            'action' => '规则action唯一KEY',
            'cycletype' => '奖励周期0:一次;1:每天;2:整点;3:间隔分钟;4:不限;',
            'cycletime' => '间隔时间',
            'rewardnum' => '奖励次数',
            'point' => '积分值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 根据规则Key获取对应的积分值
     * @param $action 规则Key
     * @return int 获取的积分值
     */
    public static function getPointByRuleAction($action)
    {
        if (empty($action))
        {
            return 0;
        }
        // 查询启用状态下的规则Key所对应的积分值
        $point = self::find()
            ->select('point')
            ->where(['available' => self::RULE_ENABLED, 'action' => $action])
            ->scalar();
        return intval($point);
    }

    /**
     * 规则是否存在并可用
     * @param $action 规则Key
     * @return bool
     */
    public static function isRuleAvailable($action)
    {
        if (empty($action))
        {
            return false;
        }
        $exist = self::find()
            ->where(['available' => self::RULE_ENABLED, 'action' => $action])
            ->count();
        return $exist;
    }

    /**
     * 获取规则对应的自增主键
     * @param $action 规则Key
     * @return int
     */
    public static function getRuleIdByAction($action)
    {
        if (empty($action))
        {
            return 0;
        }
        $id = self::find()
            ->select('rid')
            ->where(['available' => self::RULE_ENABLED, 'action' => $action])
            ->scalar();
        return intval($id);
    }

    /**
     * 获取规则对应的频道ID
     * @param $action 规则Key
     * @return int
     */
    public static function getChannelIdByAction($action)
    {
        if (empty($action))
        {
            return 0;
        }
        $chid = self::find()
            ->select('chid')
            ->where(['available' => self::RULE_ENABLED, 'action' => $action])
            ->scalar();
        return intval($chid);
    }

    /**
     * 关联频道表
     * @return type
     */
    public function getChannel()
    {
        return $this->hasOne(PointChannel::className(), ['chid' => 'chid']);
    }

    /**
     * 搜索配比规则
     * @param type $pageSize
     * @param type $offset
     * @param type $search
     * @return type
     */
    public function searchRules($pageSize, $offset, $search)
    {
        $query = self::find()->joinWith('channel', true)
                ->select([self::tableName() . '.*',
            'channelname' => PointChannel::tableName() . '.channelname',
        ]);
        if (!empty($search))
        {
            foreach ($search as $key => $value)
            {
                if ($key == 'rulealias')
                {
                    $query->andWhere(['like', self::tableName() . '.' . $key, $value]);
                }
                else
                {
                    $query->andWhere([self::tableName() . '.' . $key => $value]);
                }
            }
        }
        $count = $query->count();

        $rules = $query->orderBy([self::tableName() . '.rid' => SORT_ASC])
                ->offset($offset)
                ->limit($pageSize)
                ->asArray()
                ->all();
        return ['rules' => $rules, 'totalCount' => $count];
    }
    /**
     * 获取配比详细
     * @param string $rid
     * @return array|bool
     */
    public static function getRuleDetails($rid)
    {
        $details = self::find()->joinWith('channel', true)
                ->select([self::tableName() . '.*',
            'channelname' => PointChannel::tableName() . '.channelname'])
            ->where([self::tableName() .'.rid' => $rid])
            ->asArray(true)
            ->one();
        if($details)
        {
            return $details;
        }
        else
        {
            return false;
        }
    }
}
