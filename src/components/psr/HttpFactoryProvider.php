<?php

declare(strict_types=1);

namespace app\components\psr;

use Laminas\Diactoros\RequestFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Yii;
use yii\base\BootstrapInterface;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;

class HttpFactoryProvider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(ResponseFactoryInterface::class, ResponseFactory::class);
        $container->setSingleton(RequestFactoryInterface::class, RequestFactory::class);
        $container->setSingleton(StreamFactoryInterface::class, StreamFactory::class);
    }
}
