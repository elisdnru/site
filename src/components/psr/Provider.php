<?php

declare(strict_types=1);

namespace app\components\psr;

use Http\Client\Curl\Client;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\CacheInterface;
use Yii;
use yii\base\BootstrapInterface;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;

class Provider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(ClientInterface::class, static function () {
            return new Client(new ResponseFactory(), new StreamFactory());
        });

        $container->setSingleton(CacheInterface::class, static function () use ($app) {
            return new SimpleCache($app->cache);
        });
    }
}
