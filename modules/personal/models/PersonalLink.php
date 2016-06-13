<?php

namespace frontend\modules\personal\models;

use Yii;

/**
 * This is the model class for table "{{%rc_personal_link}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $link_name
 * @property string $link_url
 */
class PersonalLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rc_personal_link}}';
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
            [['username', 'link_name'], 'string', 'max' => 30],
            [['link_url'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户平台注册ID',
            'link_name' => '链接名称',
            'link_url' => '链接URL',
        ];
    }

    /**
     *获取个人空间的链接
     * @paras $username string
     * @return array
     * */
    public static function getPersonalLink($username){
        $per_links = [];
        $res = self::find()->select(['link_name', 'link_url'])->where('username=:username', [':username'=>$username])->all();
        foreach($res as $v){
            $per_links[] = [
                'link_name'=>$v['link_name'],
                'link_url'=>$v['link_url']
            ];
        }
        return $per_links;
    }
}
