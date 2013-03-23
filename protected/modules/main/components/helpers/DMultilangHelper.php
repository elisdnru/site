<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Diman
 * Date: 21.02.13
 * Time: 9:53
 * To change this template use File | Settings | File Templates.
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
