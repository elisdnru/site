<?php

namespace app\modules\sitemap\controllers;

use app\modules\blog\models\Post;
use app\components\Controller;
use app\modules\landing\models\Landing;
use app\modules\sitemap\components\Sitemap;
use app\modules\page\models\Page;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;
use Yii;
use yii\caching\TagDependency;
use yii\web\Response;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        $models = [];

        $models['Page'] = Page::find()->cache(0, new Tags('page'))
            ->andWhere(['system' => 0])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        $models['Landing'] = Landing::find()->cache(0, new Tags('landing'))
            ->andWhere(['system' => 0])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        $models['BlogPost'] = Post::model()->cache(0, new Tags('blog'))->published()->findAll([
            'order' => 'title ASC',
        ]);

        $models['PortfolioWork'] = Work::find()->published()
            ->cache(0, new TagDependency(['tags' => 'portfolio']))
            ->orderBy(['title' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'items' => $models,
            'page' => $this->loadSitemapPage(),
        ]);
    }

    public function actionXml(): string
    {
        if (!$xml = Yii::$app->cache->get('sitemap_xml')) {
            $sitemap = new Sitemap();

            $sitemap->addModels(Page::find()->andWhere([
                'system' => 0,
                'robots' => ['index', 'follow', 'index, nofollow'],
            ])->all(), Sitemap::WEEKLY);

            $sitemap->addModels(Landing::find()->andWhere(['system' => 0])->all(), Sitemap::WEEKLY);

            $sitemap->addModels(Post::model()->published()->findAll(), Sitemap::DAILY, 0.8);

            $xml = $sitemap->render();

            Yii::$app->cache->set('sitemap_xml', $xml, 3600);
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers['Content-Type'] = 'application/xml;charset=UTF-8';
        return $xml;
    }

    private function loadSitemapPage(): Page
    {
        if (!$page = Page::find()->cache(0, new Tags('page'))->findByPath('sitemap')) {
            $page = new Page;
            $page->title = 'Карта сайта';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
