<?php

namespace backend\modules\trust\models;

use Yii;

/**
 * This is the model class for table "vso_trust_negative_rule".
 *
 * @property integer $id
 * @property string $content
 * @property integer $point
 * @property integer $created_at
 * @property integer $updated_at
 */
class TrustNegativeRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_trust_negative_rule';
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
            [['point', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '扣分规则编号',
            'content' => '扣分规则说明',
            'point' => '扣除分值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    /**
     * 规则搜索
     * @param type $pageSize
     * @param type $offset
     * @param type $search
     * @return type
     */
    public function searchRules($pageSize, $offset, $search)
    {
        $query = self::find()->where('1=1');
        if (!empty($search))
        {
            foreach ($search as $key => $value)
            {
                if ($key == 'content')
                {
                    $query->andWhere(['like', $key, $value]);
                }
                else
                {
                    $query->andWhere([$key => $value]);
                }
            }
        }
        $count = $query->count();

        $rules = $query->orderBy(['id' => SORT_ASC])
                ->offset($offset)
                ->limit($pageSize)
                ->asArray()
                ->all();
        return ['rules' => $rules, 'totalCount' => $count];
    }


    /**
     * 所有扣分规则
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRulesNegative()
    {
        $rules = self::find()
                     ->select(['id', 'content', 'point'])
                     ->orderBy(['id' => SORT_ASC])
                     ->asArray()
                     ->all();

        return $rules;
    }

    /**
     * 根据ID获得规则信息
     * @param null $id
     * @return array|null|void|\yii\db\ActiveRecord
     */
    public static function getRulesNegativeInfo($id = null)
    {
        if(empty($id)) return;
        $rulesInfo = self::find()
                     ->where(['id' => $id])
                     ->select(['id', 'content', 'point'])
                     ->orderBy(['id' => SORT_ASC])
                     ->asArray()
                     ->one();

        return $rulesInfo;
    }
}
