<?php

namespace backend\modules\vip\models;

use Yii;

/**
 * This is the model class for table "vso_vip_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property integer $business_push
 * @property integer $shop_type
 * @property integer $proj_num_lv1
 * @property integer $proj_num_lv2
 * @property integer $render_time
 * @property integer $proj_limit
 * @property integer $proj_user_limit
 * @property integer $studio_limit
 * @property integer $studio_user_limit
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vso_vip_group';
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
            [['price'], 'number'],
            [
                [
                    'business_push',
                    'shop_type',
                    'proj_num_lv1',
                    'proj_num_lv2',
                    'render_time',
                    'proj_limit',
                    'proj_user_limit',
                    'studio_limit',
                    'studio_user_limit',
                    'status',
                    'created_at',
                    'updated_at'
                ],
                'integer'
            ],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'business_push' => 'Business Push',
            'shop_type' => 'Shop Type',
            'proj_num_lv1' => 'Proj Num Lv1',
            'proj_num_lv2' => 'Proj Num Lv2',
            'render_time' => 'Render Time',
            'proj_limit' => 'Proj Limit',
            'proj_user_limit' => 'Proj User Limit',
            'studio_limit' => 'Studio Limit',
            'studio_user_limit' => 'Studio User Limit',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 搜索会员分类列表
     * @param type $pageSize
     * @param type $offset
     * @param type $search
     * @return type
     */
    public function searchGroups($pageSize, $offset, $search)
    {
        $query = self::find();
        if (!empty($search))
        {
            foreach ($search as $key => $value)
            {
                if ($key == 'name')
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

        $groups = $query->orderBy(['price' => SORT_ASC])
            ->offset($offset)
            ->limit($pageSize)
            ->asArray()
            ->all();
        return ['groups' => $groups, 'totalCount' => $count];
    }

    /**
     * 获取会员等级
     * @return array
     */
    public static function getGroupList()
    {
        $res = self::find()->select(['id', 'name'])->asArray()->all();
        return $res;
    }

    /**
     * 获取会员年限
     * @return array
     */
    public static function getDurationList()
    {
        return [
            '1' => '1年',
            '2' => '2年',
            '3' => '3年',
            '4' => '4年',
            '5' => '5年',
        ];
    }

}
