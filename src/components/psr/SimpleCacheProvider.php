<?php

declare(strict_types=1);

namespace app\components\psr;

use Psr\SimpleCache\CacheInterface;
use Yii;
use yii\base\BootstrapInterface;

class SimpleCacheProvider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(CacheInterface::class, static function () use ($app) {
            return new SimpleCache($app->cache);
        });
    }
}
