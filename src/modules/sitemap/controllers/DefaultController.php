<?php

namespace app\modules\sitemap\controllers;

use app\components\module\sitemap\GroupsLoader;
use app\modules\blog\models\Post;
use app\components\Controller;
use app\modules\landing\models\Landing;
use app\modules\sitemap\components\Sitemap;
use app\modules\page\models\Page;
use app\modules\portfolio\models\Work;
use Yii;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\helpers\Url;
use yii\web\Response;

class DefaultController extends Controller
{
    private GroupsLoader $loader;

    /**
     * @param string $id
     * @param Module $module
     * @param GroupsLoader $loader
     * @param array $config
     */
    public function __construct($id, $module, GroupsLoader $loader, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->loader = $loader;
    }

    public function actionIndex(): string
    {
        $groups = $this->loader->getGroups();

        return $this->render('index', [
            'groups' => $groups,
        ]);
    }

    public function actionXml(): string
    {
        if (!$xml = Yii::$app->cache->get('sitemap_xml')) {
            $sitemap = new Sitemap();

            foreach ($this->loader->getGroups() as $group) {
                foreach ($group->items as $item) {
                    if ($xml = $item->xml) {
                        $sitemap->addLoc(
                            Url::to($item->url, true),
                            $xml->changeFreq,
                            $xml->priority,
                            $xml->lastMod
                        );
                    }
                }
            }

            $xml = $sitemap->render();

            Yii::$app->cache->set('sitemap_xml', $xml, 3600);
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers['Content-Type'] = 'application/xml;charset=UTF-8';
        return $xml;
    }
}
