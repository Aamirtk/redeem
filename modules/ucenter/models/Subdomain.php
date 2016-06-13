<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/05/09
 * Time: 17:00
 */
namespace frontend\modules\ucenter\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "{{%subdomain}}".
 *
 * @property integer $id
 * @property string $subdomain
 * @property integer $is_deleted
 * @property integer $created_at
 */
class Subdomain extends \yii\db\ActiveRecord
{
    /**
     * 删除状态
     */
    const NO_DELETE = 1;//未删除、正常
    const IS_DELETE = 2;//删除

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subdomain}}';
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
            [['type', 'is_deleted', 'created_at'], 'integer'],
            [['subdomain'], 'string', 'max' => 15],
            [['created_at'], 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subdomain' => '二级域名名称',
            'type' => '类型（1-受保护的域名；2-非法的域名）',
            'is_deleted' => '是否删除（1-未删除；2-已删除）',
            'created_at' => '创建时间',
        ];
    }

    /**
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info($where = []) {
        if (empty($where)) {
            return false;
        }

        $obj = self::findOne($where);
        if (!empty($obj)) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list($where = [], $order = 'created_at desc', $page = 1, $limit = 20) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        $_obj->orderBy($order);

        if (!empty($limit)) {
            $offset = ($page - 1) * $limit;
            $_obj->offset($offset)->limit($limit);
        }

        return $_obj->asArray(true)->all();
    }

    /**
     * 保存记录
     * @param $data array
     * @return array|boolean
     */
    public function _save($data) {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                if (!empty($data['id'])) {//修改
                    $id = $data['id'];
                    $ret = $_mdl->updateAll($data, ['id' => $id]);
                } else {//增加
                    foreach ($data as $k => $v) {
                        $_mdl->$k = $v;
                    }
                    if($_mdl->validate()){
                        $ret = $_mdl->insert();
                    }else{
                        return false;
                    }
                }

                if ($ret !== false) {
                    return true;
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 删除记录
     * @param $where array
     * @return array|boolean
     */
    public static function _delete($where) {
        if (empty($where)) {
            return false;
        }
        try {
            return (new self)->deleteAll($where);
        } catch (Exception $e) {

        }
        return false;
    }
}
