<?php

namespace frontend\modules\enterprise\models;

use common\models\CommonIndustry;
use Yii;

/**
 * This is the model class for table "{{%crm_industries}}".
 *
 * @property integer $id
 * @property string $username
 * @property integer $company_id
 * @property integer $ptype
 * @property integer $stype
 * @property integer $ctype
 * @property integer $size
 */
class CrmIndustries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crm_industries}}';
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
            [['company_id', 'ptype', 'stype', 'ctype', 'size'], 'integer'],
            [['username'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '企业注册号ID',
            'company_id' => 'CRM企业编号，用于关联',
            'ptype' => '一级分类',
            'stype' => '二级分类',
            'ctype' => '三级分类',
            'size' => '人员规模',
        ];
    }

    public static function getCrmPtypeIndus($username)
    {

    }

    /**
     * 增加公司对应的一级行业
     * @param $username 用户名
     * @param $indus_pid 行业编号，一级行业
     * @return bool（true=>添加成功，false=>添加失败）
     */
    public static function createCrmIndus($username, $indus_pid)
    {
        if (empty($username) || empty($indus_pid))
        {
            return false;
        }
        $indus_exist = CommonIndustry::find()->where(['id' => $indus_pid, 'lvl' => 0])->count();
        if (!$indus_exist)
        {
            return false;
        }
        // 对应的公司行业是否已经存在，避免重复数据
        $exist = self::find()->where(['username' => $username, 'ptype' => $indus_pid])->count();
        if ($exist)
        {
            return true;
        }
        //是否已经入驻人才库
        $company_id=CrmCompany::getCompanyidByUsername($username);
        if(empty($company_id))
        {
            return false;
        }
        $model = new CrmIndustries();
        $model->setAttributes([
            'username' => $username,
            'company_id' => CrmCompany::getCompanyidByUsername($username),
            'ptype' => $indus_pid
        ]);
        return $model->save();
    }
}
