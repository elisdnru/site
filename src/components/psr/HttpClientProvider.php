<?php

declare(strict_types=1);

namespace app\components\psr;

use Http\Client\Curl\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Container;

class HttpClientProvider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(ClientInterface::class, static function (Container $container) {
            /** @var ResponseFactoryInterface $responseFactory */
            $responseFactory = $container->get(ResponseFactoryInterface::class);
            /** @var StreamFactoryInterface $streamFactory */
            $streamFactory = $container->get(StreamFactoryInterface::class);
            return new Client($responseFactory, $streamFactory);
        });
    }
}
