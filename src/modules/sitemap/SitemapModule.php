<?php

class SitemapModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.sitemap.components.*',
        ]);
    }

    public function getName()
    {
        return 'Карта сайта';
    }

    public static function rules()
    {
        return [
            'sitemap' => 'sitemap/default/index',
            ['sitemap/default/xml', 'pattern' => 'sitemap.xml', 'urlSuffix' => ''],
        ];
    }
}
