<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use Yii;
use yii\base\BootstrapInterface;

class Provider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(GroupsFetcher::class, static function () use ($app) {
            return new GroupsFetcher($app);
        });
    }
}