<?php

namespace frontend\modules\enterprise\models;

use common\models\CommonIndustry;
use Yii;

/**
 * This is the model class for table "tb_crm_work".
 *
 * @property integer $id
 * @property string $username
 * @property integer $company_id
 * @property integer $ptype
 * @property integer $work_id
 * @property string $work_name
 * @property string $work_price
 * @property string $work_period
 * @property string $work_url
 * @property integer $status
 * @property integer $zan
 * @property string $content
 * @property integer $order
 * @property string $tag
 * @property integer $is_index
 * @property integer $create_time
 * @property integer $update_time
 */
class CrmWork extends \yii\db\ActiveRecord
{
    const HOT_WORK = 1;
    const NORMAL_WORK = 0;
    const STATUS_DELETED = 1;   // 已删除
    const STATUS_ACTIVE = 0;    // 未删除
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crm_work}}';
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
            [['ptype', 'work_id', 'status', 'zan', 'order', 'is_index', 'create_time', 'update_time'], 'integer'],
            [['create_time'], 'default', 'value' => time()],
            [['content'], 'string'],
            [['username'], 'string', 'max' => 20],
            [['work_name', 'work_price', 'work_period'], 'string', 'max' => 30],
            [['work_url'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'ptype' => 'Ptype',
            'work_id' => 'Work ID',
            'work_name' => 'Work Name',
            'work_price' => 'Work Price',
            'work_period' => 'Work Period',
            'work_url' => 'Work Url',
            'status' => 'Status',
            'zan' => 'Zan',
            'content' => 'Content',
            'order' => 'Order',
            'tag' => 'Tag',
            'is_index' => 'Is Index',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * 获取单个文件 rj
     * */
    public static function getInfo($where = [], $order = '', $andwhere = [])
    {
        if (empty($where)){
            return false;
        }

        $obj = self::find()
            ->where($where)
            ->andWhere($andwhere)
            ->orderBy($order)
            ->one();
        if (!empty($obj)){
            return $obj->toArray();
        }
        return [];
    }

    /**
     * 获取类型
     * */
    public static function getListType($where = [], $order = '', $group = '')
    {
        return self::find()
            ->with('industry')
            ->where($where)
            ->orderBy($order)
            ->groupBy($group)
            ->asArray(true)
            ->all();
    }

    public function getIndustry(){
        return $this->hasOne(CommonIndustry::className(),['id' => 'ptype']);
    }

    /**
     * 获取列表 rj
     * */
    public static function getList($where = [], $order = '', &$totalCount = 0, $offset = 0, $limit = 10)
    {
        //获取数量
        $totalCount = self::find()
            ->where($where)
            ->asArray()
            ->count();

        return self::find()
            ->where($where)
            ->orderBy($order)
            ->offset($offset)
            ->limit($limit)
            ->asArray(true)
            ->all();
    }

    /**
     * 设置信息 rj
     * */
    public static function setInfo($data){
        if (!$data || !is_array($data))
        {
            return false;
            //throw new CDbException(Yii::t('ext.RDbCommand', 'Columns should be a valid one demention array.'));
        }

        $obj = self::find()->where(['id'=>$data['id']])->one();
        if (!empty($obj)){
            $obj->setAttributes($data);
            /*
            if (!$obj->validate())
            {
                print_r($obj->getErrors());
                exit;
            }
            */
            return $obj->update();
        }
        else{
            $model = new EntCase();
            foreach ($data as $key => $val)
            {
                $model->setAttribute($key, $val);
            }

            return $model->insert();
        }
    }

    /**
     * 根据作品编号获取username
     * @param $work_id 作品编号
     * @return bool|string
     */
    public static function getCrmUsernameByWorkId($work_id)
    {
        return self::find()->select('username')->where(['id' => $work_id])->scalar();
    }
}