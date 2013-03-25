<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DMultilangHelper
{
    public static function enabled()
    {
        return count(Yii::app()->params['translatedLanguages']) > 1;
    }

    public static function suffixList()
    {
        $list = array();
        foreach (Yii::app()->params['translatedLanguages'] as $l => $lang){
            if ($l === Yii::app()->params['defaultLanguage']) {
                $suffix = '';
                $lang = '';
            } else {
                $suffix = '_' . $l;
            }
            $list[$suffix] = $lang;
        }
        return $list;
    }
}
