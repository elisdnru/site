<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DLanguageUrlHelper
{
    public static function normalize($url)
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

    public static function getUrl()
    {
        return self::normalize(Yii::app()->getRequest()->getUrl());
    }

    public static function getRequestUri()
    {
        return self::normalize(Yii::app()->request->getRequestUri());
    }
}
