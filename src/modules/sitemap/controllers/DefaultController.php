<?php

namespace app\modules\sitemap\controllers;

use app\modules\blog\models\Post;
use app\components\Controller;
use app\modules\sitemap\components\Sitemap;
use app\modules\page\models\Page;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex(): void
    {
        $models = [];

        $models['Page'] = Page::model()->cache(0, new Tags('page'))->findAll([
            'condition' => 'system = 0',
            'order' => 'title ASC',
        ]);

        $models['BlogPost'] = Post::model()->cache(0, new Tags('blog'))->published()->findAll([
            'order' => 'title ASC',
        ]);

        $models['PortfolioWork'] = Work::model()->cache(0, new Tags('portfolio'))->published()->findAll([
            'order' => 'title ASC',
        ]);

        $this->render('index', [
            'items' => $models,
            'page' => $this->loadSitemapPage(),
        ]);
    }

    public function actionXml(): void
    {
        if (!$xml = Yii::app()->cache->get('sitemap_xml')) {
            $sitemap = new Sitemap();

            $sitemap->addModels(Page::model()->findAll(['condition' => 'system = 0 AND robots IN (\'index, follow\', \'index, nofollow\')']), Sitemap::WEEKLY);

            $sitemap->addModels(Post::model()->published()->findAll(), Sitemap::DAILY, 0.8);

            $sitemap->addModels(Work::model()->findAll(), Sitemap::WEEKLY);

            $xml = $sitemap->render();

            Yii::app()->cache->set('sitemap_xml', $xml, 3600);
        }

        header('Content-type: text/xml');
        echo $xml;
        Yii::app()->end();
    }

    /**
     * @return Page
     */
    private function loadSitemapPage(): Page
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('sitemap')) {
            $page = new Page;
            $page->title = 'Карта сайта';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
