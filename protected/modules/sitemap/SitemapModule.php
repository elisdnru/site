<?php

class SitemapModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.sitemap.components.*',
        ));
    }

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
