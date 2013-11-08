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
			'sitemap'=>'sitemap/default/index',
            array('sitemap/default/xml', 'pattern'=>'sitemap.xml', 'urlSuffix'=>''),
        );
    }
}
