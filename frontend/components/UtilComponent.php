<?php
namespace frontend\components;

use yii;
use yii\base\Component;

class UtilComponent extends Component
{
    public function toXml($obj)
    {
        $xml = '<xml>';
        foreach ($obj as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } elseif (is_object($val)) {
                $sXml = '';
                foreach ($val as $sk => $sv) {
                    if (is_numeric($val)) {
                        $sXml .= "<" . $sk . ">" . $sv . "</" . $sk . ">";
                    } else {
                        $sXml .= "<" . $sk . "><![CDATA[" . $sv . "]]></" . $sk . ">";
                    }
                }
                $xml .= "<" . $key . ">" . $sXml . "</" . $key . ">";
//                $xml .= $this->toXml($val);
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= '</xml>';
        return $xml;
    }
}