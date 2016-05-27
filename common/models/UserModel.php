<?php

namespace common\models;

use backend\modules\user\models\VsoUser;
use yii;

class UserModel extends VsoUser
{
    /**
     * 根据账号获取UC用户基本信息
     * @param string|integer $name 账号（用户名/手机号/邮箱）
     * @return array
     */
    public static function getUserInfoByName($name)
    {
        if (empty($name))
        {
            return [];
        }
        if (self::isEmail($name))
        {
            $where = 'email';
        }
        elseif (self::isMobile($name))
        {
            $where = 'mobile';
        }
        else
        {
            $where = 'username';
        }
        $user = VsoUser::find()
            ->select('username, id, email, mobile, status, password')
            ->where([$where => $name])
            ->asArray()
            ->one();
        return empty($user) ? [] : $user;
    }

    /**
     * 根据用户名获取UC用户编号
     * @param string $username 用户名
     * @return integer 用户编号
     */
    public static function getUserIdByUsername($username)
    {
        if (empty($username))
        {
            return '';
        }
        $uid = VsoUser::find()
            ->select('id')
            ->where(['username' => $username])
            ->scalar();
        return empty($uid) ? '' : $uid;
    }

    /**
     * 根据用户名获取用户昵称
     * @todo，使用redis缓存
     * @param string $username 用户名
     * @return string 昵称
     */
    public static function getUserNicknameByUsername($username)
    {
        if (empty($username))
        {
            return '';
        }
        $nickname = VsoUser::find()
            ->select('nickname')
            ->where(['username' => $username])
            ->scalar();

        return empty($nickname) ? '' : $nickname;
    }

    /**
     * 用户名是否存在
     * @param string $username 用户名
     * @return bool（true=>存在，false=>不存在）
     */
    public static function isAvailableUsername($username)
    {
        if (empty($username))
        {
            return false;
        }
        // 用户信息
        $user = VsoUser::findOne(['username' => $username]);
        // 用户不存在
        if (empty($user))
        {
            return false;
        }
        // 用户未激活
        if ($user['status'] != VsoUser::USER_ACTIVE)
        {
            return false;
        }
        return true;
    }

    /**
     * 转码：gbk转utf-8
     * @param string $str
     * @return string
     */
    public static function iconvGbkToUtf8($str)
    {
        return empty($str) ? $str : iconv('UTF-8', 'GBK', $str);
    }

    /**
     * 日期格式化：时间戳转字符串
     * @param integer $timeStamp 时间戳，10位
     * @return string 格式化后的时间
     */
    public static function timestampFormat($timeStamp)
    {
        return $timeStamp > 0 ? date("Y-m-d H:i:s", $timeStamp) : '';
    }
}
