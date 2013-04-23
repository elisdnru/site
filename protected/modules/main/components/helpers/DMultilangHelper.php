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
        $enabled = self::enabled();
        foreach (Yii::app()->params['translatedLanguages'] as $lang => $name){
            if ($lang === Yii::app()->params['defaultLanguage']) {
                $suffix = '';
                $list[$suffix] = $enabled ? $name : '';
            } else {
                $suffix = '_' . $lang;
                $list[$suffix] = $name;
            }
        }
        return $list;
    }

    public static function processLangInUrl($url)
    {
        $domains = explode('/', ltrim($url, '/'));

        $isLangExists = in_array($domains[0], array_keys(Yii::app()->params['translatedLanguages']));
        $isDefaultLang = $domains[0] == Yii::app()->params['defaultLanguage'];

        if ($isLangExists && !$isDefaultLang)
        {
            $lang = array_shift($domains);
            Yii::app()->setLanguage($lang);
        }

        return '/' . implode('/', $domains);
    }

    public static function addLangToUrl($url)
    {
        $domains = explode('/', ltrim($url, '/'));
        $isHasLang = in_array($domains[0], array_keys(Yii::app()->params['translatedLanguages']));
        $isDefaultLang = Yii::app()->getLanguage() == Yii::app()->params['defaultLanguage'];

        if ($isHasLang && $isDefaultLang)
            array_shift($domains);

        if (!$isHasLang && !$isDefaultLang)
            array_unshift($domains, Yii::app()->getLanguage());

        return '/' . implode('/', $domains);
    }
}
