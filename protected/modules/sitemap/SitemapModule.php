<?php

class SitemapModule extends DWebModule
{
    public static function system()
    {
        return true;
    }

    public function getName()
    {
        return 'Карта сайта';
    }

    public static function rules()
    {
        return array(
            array('sitemap/default/index', 'pattern'=>'sitemap.xml', 'urlSuffix'=>''),
        );
    }
}
