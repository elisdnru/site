<?php

namespace app\modules\sitemap\controllers;

use BlogPost;
use app\modules\main\components\DController;
use app\modules\sitemap\components\DSitemap;
use app\components\module\DUrlRulesHelper;
use Page;
use PortfolioWork;
use Tags;
use Yii;

class DefaultController extends DController
{
    public function actionIndex()
    {
        $models = [];

        DUrlRulesHelper::import('page');

        $models['Page'] = Page::model()->cache(0, new Tags('page'))->findAll([
            'condition' => 'system = 0',
            'order' => 'title ASC',
        ]);

        DUrlRulesHelper::import('blog');

        $models['BlogPost'] = BlogPost::model()->cache(0, new Tags('blog'))->published()->findAll([
            'order' => 'title ASC',
        ]);

        DUrlRulesHelper::import('portfolio');

        $models['PortfolioWork'] = PortfolioWork::model()->cache(0, new Tags('portfolio'))->published()->findAll([
            'order' => 'title ASC',
        ]);

        $this->render('index', [
            'items' => $models,
            'page' => $this->loadSitemapPage(),
        ]);
    }

    public function actionXml()
    {
        if (!$xml = Yii::app()->cache->get('sitemap_xml')) {
            $sitemap = new DSitemap();

            DUrlRulesHelper::import('page');

            $sitemap->addModels(Page::model()->findAll(['condition' => 'system = 0 AND robots IN (\'index, follow\', \'index, nofollow\')']), DSitemap::WEEKLY);

            DUrlRulesHelper::import('blog');

            $sitemap->addModels(BlogPost::model()->published()->findAll(), DSitemap::DAILY, 0.8);

            DUrlRulesHelper::import('portfolio');

            $sitemap->addModels(PortfolioWork::model()->findAll(), DSitemap::WEEKLY);

            $xml = $sitemap->render();

            Yii::app()->cache->set('sitemap_xml', $xml, 3600);
        }

        header("Content-type: text/xml");
        echo $xml;
        Yii::app()->end();
    }

    /**
     * @return Page
     */
    private function loadSitemapPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('sitemap')) {
            $page = new Page;
            $page->title = 'Карта сайта';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
