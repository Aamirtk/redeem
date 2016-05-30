<?php

namespace common\lib;

use Yii;

/**
 * 过滤
 *
 */
class Filter
{
    /**
     * 过滤特殊字符
     * @param type $string
     * @return type
     */
    public static function escape($string)
    {
        $search  = array('/</i', '/>/i', '/\">/i', '/\bunion\b/i', '/load_file(\s*(\/\*.*\*\/)?\s*)+\(/i',
            '/into(\s*(\/\*.*\*\/)?\s*)+outfile/i', '/\bor\b/i', '/\<([\/]?)script([^\>]*?)\>/si',
            '/\<([\/]?)iframe([^\>]*?)\>/si', '/\<([\/]?)frame([^\>]*?)\>/si');
        $replace = array('&lt;', '&gt;', '&quot;&gt;', 'union&nbsp;', 'load_file&nbsp; (',
            'into&nbsp; outfile', 'or&nbsp;', '&lt;\\1script\\2&gt;', '&lt;\\1iframe\\2&gt;',
            '&lt;\\1frame\\2&gt;');
        if (is_array($string))
        {
            $key  = array_keys($string);
            $size = sizeof($key);
            for ($i = 0; $i < $size; $i ++)
            {
                $string [$key [$i]] = self::escape($string [$key [$i]]);
            }
        }
        else
        {
            $string = str_replace(array('\n', '\r'),
                                  array(chr(10), chr(13)),
                                                     preg_replace($search,
                                                                  $replace,
                                                                  $string));
        }
        return $string;
    }

    /**
     * 处理js escape 编码
     */
    public static function unescape($escstr)
    {
        preg_match_all("/%u[0-9A-Za-z]{4}|%.{2}|[0-9a-zA-Z.+-_]+/", $escstr,
                       $matches);
        $ar = &$matches [0];
        $c  = "";
        foreach ($ar as $val)
        {
            if (substr($val, 0, 1) != "%")
            {
                $c .= $val;
            }
            elseif (substr($val, 1, 1) != "u")
            {
                $x = hexdec(substr($val, 1, 2));
                $c .= chr($x);
            }
            else
            {
                $val = intval(substr($val, 2), 16); // 0000-007F
                if ($val < 0x7F)
                {
                    $c .= chr($val); // 0080-0800
                }
                elseif ($val < 0x800)
                {
                    $c .= chr(0xC0 | ($val / 64));
                    $c .= chr(0x80 | ($val % 64)); // 0800-FFFF
                }
                else
                {
                    $c .= chr(0xE0 | (($val / 64) / 64));
                    $c .= chr(0x80 | (($val / 64) % 64));
                    $c .= chr(0x80 | ($val % 64));
                }
            }
        }
        strtolower(CHARSET) == 'gbk' and $c = self::utftogbk($c);
        return $c;
    }

}

?>