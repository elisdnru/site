<?php

namespace app\modules\sitemap\controllers;

use app\components\module\sitemap\GroupsFetcher;
use app\components\Controller;
use app\modules\sitemap\components\Sitemap;
use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Response;

class DefaultController extends Controller
{
    private GroupsFetcher $fetcher;

    /**
     * @param string $id
     * @param Module $module
     * @param GroupsFetcher $fetcher
     * @param array $config
     */
    public function __construct($id, $module, GroupsFetcher $fetcher, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->fetcher = $fetcher;
    }

    public function actionIndex(): string
    {
        $groups = $this->fetcher->getGroups();

        return $this->render('index', [
            'groups' => $groups,
        ]);
    }

    public function actionXml(): string
    {
        if (!$xml = Yii::$app->cache->get('sitemap_xml')) {
            $sitemap = new Sitemap();

            foreach ($this->fetcher->getGroups() as $group) {
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
