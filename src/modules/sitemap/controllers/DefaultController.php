<?php

namespace app\modules\sitemap\controllers;

use app\components\module\sitemap\GroupsFetcher;
use app\components\Controller;
use app\modules\sitemap\components\Sitemap;
use yii\base\Module;
use yii\caching\CacheInterface;
use yii\helpers\Url;
use yii\web\Response;

class DefaultController extends Controller
{
    private GroupsFetcher $fetcher;

    public function __construct(string $id, Module $module, GroupsFetcher $fetcher, array $config = [])
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

    public function actionXml(CacheInterface $cache, Response $response): Response
    {
        if (!$xml = $cache->get('sitemap_xml')) {
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

            $cache->set('sitemap_xml', $xml, 3600);
        }

        $response->format = Response::FORMAT_RAW;
        $response->headers['Content-Type'] = 'application/xml;charset=UTF-8';
        $response->content = (string)$xml;
        return $response;
    }
}
