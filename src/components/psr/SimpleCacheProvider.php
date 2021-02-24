<?php

declare(strict_types=1);

namespace app\components\psr;

use Psr\SimpleCache\CacheInterface;
use Yii;
use yii\base\BootstrapInterface;
use yii\caching\CacheInterface as YiiCacheInterface;
use yii\di\Container;

class SimpleCacheProvider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(CacheInterface::class, static function (Container $container) {
            return new SimpleCacheAdapter(
                $container->get(YiiCacheInterface::class)
            );
        });
    }
}
