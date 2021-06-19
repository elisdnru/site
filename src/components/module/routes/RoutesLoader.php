<?php

declare(strict_types=1);

namespace app\components\module\routes;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\UrlManager;

class RoutesLoader implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $fetcher = $container->get(RoutesFetcher::class);
        $urlManager = $container->get(UrlManager::class);
        $urlManager->addRules($fetcher->getRules());
    }
}
