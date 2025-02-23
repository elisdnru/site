<?php

declare(strict_types=1);

namespace app\components\module\routes;

use Override;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\UrlManager;

final class RoutesLoader implements BootstrapInterface
{
    #[Override]
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $fetcher = $container->get(RoutesFetcher::class);
        $urlManager = $container->get(UrlManager::class);
        $urlManager->addRules($fetcher->getRules());
    }
}
