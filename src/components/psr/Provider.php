<?php

declare(strict_types=1);

namespace app\components\psr;

use Http\Client\Curl\Client;
use Laminas\Diactoros\RequestFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Yii;
use yii\base\BootstrapInterface;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;
use yii\di\Container;

class Provider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(ResponseFactoryInterface::class, ResponseFactory::class);
        $container->setSingleton(RequestFactoryInterface::class, RequestFactory::class);
        $container->setSingleton(StreamFactoryInterface::class, StreamFactory::class);

        $container->setSingleton(ClientInterface::class, static function (Container $container) {
            /** @var ResponseFactoryInterface $responseFactory */
            $responseFactory = $container->get(ResponseFactoryInterface::class);
            /** @var StreamFactoryInterface $streamFactory */
            $streamFactory = $container->get(StreamFactoryInterface::class);
            return new Client($responseFactory, $streamFactory);
        });

        $container->setSingleton(CacheInterface::class, static function () use ($app) {
            return new SimpleCache($app->cache);
        });
    }
}
