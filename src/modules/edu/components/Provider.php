<?php

declare(strict_types=1);

namespace app\modules\edu\components;

use app\modules\edu\components\api\Api;
use app\modules\edu\components\api\client\Cached;
use app\modules\edu\components\api\client\Muted;
use Http\Client\Curl\Client;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Container;

class Provider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(Api::class, static function (Container $container) use ($app) {
            /** @var CacheInterface $cache */
            $cache = $container->get(CacheInterface::class);
            /** @var ResponseFactoryInterface $responseFactory */
            $responseFactory = $container->get(ResponseFactoryInterface::class);
            /** @var RequestFactoryInterface $requestFactory */
            $requestFactory = $container->get(RequestFactoryInterface::class);
            return new Api(
                new Muted(
                    new Cached(
                        new Client(),
                        $cache,
                        3600
                    ),
                    $app->getErrorHandler(),
                    $responseFactory
                ),
                $requestFactory,
                $app->params['deworker_api_url']
            );
        });
    }
}
