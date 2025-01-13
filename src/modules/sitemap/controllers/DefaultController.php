<?php

declare(strict_types=1);

namespace app\modules\sitemap\controllers;

use app\components\module\sitemap\GroupsFetcher;
use app\modules\sitemap\components\Sitemap;
use yii\caching\CacheInterface;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

final class DefaultController extends Controller
{
    public function actionIndex(GroupsFetcher $fetcher): string
    {
        $groups = $fetcher->getGroups();

        return $this->render('index', [
            'groups' => $groups,
        ]);
    }

    public function actionXml(CacheInterface $cache, GroupsFetcher $fetcher, Response $response): Response
    {
        if (!$xml = (string)$cache->get('sitemap_xml')) {
            $sitemap = new Sitemap();

            foreach ($fetcher->getGroups() as $group) {
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
        $response->headers->set('Content-Type', 'application/xml;charset=UTF-8');
        $response->content = $xml;
        return $response;
    }
}
