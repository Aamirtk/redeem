<?php

/**
 * Created by PhpStorm.
 * User: xiaoqing
 * Date: 2015/7/2
 * Time: 11:08
 */

namespace common\lib;


class Category {

    //获取分类关系列表
    public function _get_tree($cate_list, $fid = 0, $level = 0, $str = '─', $firstStr = '├', $endStr = '└') {
        $tree = [];
        foreach ($cate_list as $k => $v) {
            if ($v['f_id'] == $fid) {
                $v['level'] = $level + 1;
                if ($level == 0) {
                    $v['full_name'] = $v['name'];
                } else {
                    $v['full_name'] = str_repeat('&nbsp;&nbsp;&nbsp;', $level) . $firstStr . $str . $v['name'];
                }

                $tree[] = $v;
                $tree = array_merge($tree, $this->_get_tree($cate_list, $v['c_id'], $level + 1));
            }
        }
        return $tree;
    }

    //获取下一级子分类
    public function _get_son($cate_list, $fid) {
        $data = [];
        foreach ($cate_list as $v) {
            if ($v['f_id'] == $fid) {
                $data[$v['c_id']] = $v;
            }
        }
        return $data;
    }

    //是否含有子分类
    public function _has_son($cate_list, $fid) {
        if (empty($fid) && $fid != 0) {
            return false;
        }
        foreach ($cate_list as $v) {
            if ($v['f_id'] == $fid) {
                return true;
            }
        }
        return false;
    }

    //获取父级分类对应层级关系
    function _get_parent_class($cate_list, $id) {
        if (empty($cate_list)) {
            return false;
        }
        $info = [];
        foreach ($cate_list as $val) {
            if ($val['c_id'] == $id) {
                $info[] = $val;
                if ($val['f_id'] != 0) {
                    $info = array_merge($info, $this->_get_parent_class($cate_list, $val['f_id']));
                }
                break;
            }
        }
        return $info;
    }

    //获取无限级子级
    function _get_all_son_class($cate_list, $id) {
        if (empty($cate_list) || empty($id)) {
            return false;
        }
        $info = [];
        foreach ($cate_list as $val) {
            if ($val['f_id'] == $id) {
                $info[] = $val;
                if ($this->_has_son($cate_list, $val['c_id'])) {
                    $info = array_merge($info, $this->_get_all_son_class($cate_list, $val['c_id']));
                }
            }
        }
        return $info;
    }

    //获取父级和子级分类列表
    function _get_son_and_parent_class($cate_list, $id) {
        $_parent_list = $this->_get_parent_class($cate_list, $id);
        $_son_list = $this->_get_all_son_class($cate_list, $id);
        return array_merge($_parent_list, $_son_list);
    }
}