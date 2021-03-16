<?php

declare(strict_types=1);

namespace app\components\psr;

use Http\Client\Curl\Client;
use Psr\Http\Client\ClientInterface;
use Yii;
use yii\base\BootstrapInterface;

class HttpClientProvider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(ClientInterface::class, Client::class);
    }
}
