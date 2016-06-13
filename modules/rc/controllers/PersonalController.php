<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/11/13
 * Time: 10:45
 */

namespace frontend\modules\rc\controllers;

use common\models\RcPersonalModuleTemp;
use yii;
use yii\web\Controller;
use common\models\RcPersonalWidget;
use common\models\RcPersonalPushInfo;

class PersonalController extends Controller
{
    function actionIndex($type = '')
    {
        //获取
        $temps = RcPersonalModuleTemp::_get_list(['status' => 1]);
        if (!empty($temps))
        {
            foreach ($temps as $val)
            {
                $_temp_list[$val['id']] = $val;
            }
        }

        //获取挂件
        $_widgets = RcPersonalWidget::_get_list([], 'sort desc');
        $_widgets_list = [];
        if (!empty($_widgets))
        {
            foreach ($_widgets as $val)
            {
                $_widgets_list[$val['r_id']][] = $val;
            }
        }

        //获取推送数据
        $sql = 'select * from (select * from {{%rc_personal_push_info}} ORDER BY create_time desc) tb GROUP BY widget_id, p_id';
        $list = RcPersonalPushInfo::_query($sql);
        $_push_info = [];
        if (!empty($list))
        {
            foreach ($list as $val)
            {
                $_push_info[$val['r_id']][$val['widget_id']][$val['p_id']] = [
                    'widget_id' => $val['widget_id'],
                    'p_id' => $val['p_id'],
                    'r_id' => $val['r_id'],
                    'content' => json_decode($val['content'], true),
                ];
            }
        }
        $data = [
            '_this_obj' => $this,
            '_widgets_list' => $_widgets_list,
            '_push_info' => $_push_info,
            '_temp_list' => $_temp_list,
        ];

        if ($type == 'create'):
            $code = $this->render('index', $data, true);
            $_static_file_path = yii::$app->basePath . '/webrc/personal_index.html';
            if (!empty($code))
            {
                $r = @file_put_contents($_static_file_path, $code);
                if ($r > 0)
                {
                    exit('Success!');
                }
            }
            exit('Fail!');
        else:
            return $this->render('index', $data);
        endif;
    }

    //封面人物
    function actionCover_story()
    {
        $_page_config = [
            'title' => '创意封面人物_创意云·封面人物',
        ];
        $w_id = intval(yii::$app->request->get('w_id'));
        $year = intval(yii::$app->request->get('y'));
        $month = intval(yii::$app->request->get('m'));
        if (empty($w_id))
        {
            exit('40401');
        }

        $_list = RcPersonalPushInfo::_get_list(['widget_id' => $w_id], 'create_time desc', 0, 0);
        $_info_list = [];
        $_date_list = [];
        $_month_list = [];
        if (!empty($_list))
        {

            foreach ($_list as $val)
            {
                $_this_val = json_decode($val['content'], true);
                if (!empty($_this_val['num']))
                {
                    $_month_list[] = $_this_val['date'];
                    if(empty($_this_val['date'])){
                        continue;
                    }

                    $_this_val['year'] = date('Y', strtotime($_this_val['date']));
                    $_this_val['month'] = date('m', strtotime($_this_val['date']));

                    //按日期筛选
                    if (!empty($year) && !empty($month) && ($_this_val['year'] != $year || $_this_val['month'] != $month))
                    {
                        continue;
                    }

                    $_info_list[$_this_val['num']][$val['p_id']] = $_this_val;

                }
            }
            if (!empty($_month_list))
            {
                $_month_list = array_unique($_month_list);
                sort($_month_list);
                foreach ($_month_list as $key => $val)
                {
                    if(empty($val)){
                        continue;
                    }
                    $_date = strtotime($val);
                    $_date_list[date('Y', $_date)][date('m', $_date)] = $val;
                }
            }
        }
        if (empty($year) || empty($month))
        {
            $_now_date = '全部';
        }
        else
        {
            $_now_date = $year . '年' . $month . '月';
        }

        //获取人才周刊挂件ID
        $_widget_info = RcPersonalWidget::_get_info(['temp_id' => 6]);
        $data = [
            '_info_list' => $_info_list,
            '_date_list' => $_date_list,
            '_this_obj' => $this,
            '_page_config' => $_page_config,
            '_widget_id' => $w_id,
            'y' => $year,
            'm' => $month,
            '_now_date' => $_now_date,
            '_weekly_widget_id' => $_widget_info['widget_id'],
        ];
        return $this->render('cover_story', $data);
    }

    //创意周刊
    function actionWeekly()
    {
        $_page_config = [
            'title' => '创意人才周刊_创意云·人才库',
        ];
        $w_id = intval(yii::$app->request->get('w_id'));
        $year = intval(yii::$app->request->get('y'));
        $month = intval(yii::$app->request->get('m'));
        if (empty($w_id))
        {
            exit('40401');
        }

        $_list = RcPersonalPushInfo::_get_list(['widget_id' => $w_id], 'create_time desc', 0, 0);
        $_info_list = [];
        $_date_list = [];
        $_month_list = [];
        if (!empty($_list))
        {
            foreach ($_list as $val)
            {
                $_this_val = json_decode($val['content'], true);
                if (!empty($_this_val['num']))
                {
                    $_month_list[] = $_this_val['date'];

                    $_this_val['year'] = date('Y', strtotime($_this_val['date']));
                    $_this_val['month'] = date('m', strtotime($_this_val['date']));

                    //按日期筛选
                    if (!empty($year) && !empty($month) && ($_this_val['year'] != $year || $_this_val['month'] != $month))
                    {
                        continue;
                    }

                    $_info_list[$_this_val['num']][$val['p_id']] = $_this_val;
                }
            }

            if (!empty($_month_list))
            {
                $_month_list = array_unique($_month_list);
                sort($_month_list);
                foreach ($_month_list as $key => $val)
                {
                    $_date = strtotime($val);
                    $_date_list[date('Y', $_date)][date('m', $_date)] = $val;
                }
            }
        }
        if (empty($year) || empty($month))
        {
            $_now_date = '全部';
        }
        else
        {
            $_now_date = $year . '年' . $month . '月';
        }

        //获取人才周刊挂件ID
        $_widget_info = RcPersonalWidget::_get_info(['temp_id' => 7]);

        $data = [
            '_info_list' => $_info_list,
            '_date_list' => $_date_list,
            '_this_obj' => $this,
            '_page_config' => $_page_config,
            '_widget_id' => $w_id,
            'y' => $year,
            'm' => $month,
            '_now_date' => $_now_date,
            'cover_story_widget_id' => $_widget_info['widget_id'],
        ];
        return $this->render('weekly', $data);
    }

}