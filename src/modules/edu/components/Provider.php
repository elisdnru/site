<?php

declare(strict_types=1);

namespace app\modules\edu\components;

use app\modules\edu\components\api\Api;
use app\modules\edu\components\api\client\Cached;
use app\modules\edu\components\api\client\Muted;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Container;

final class Provider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(Api::class, static function (Container $container) use ($app) {
            return new Api(
                new Muted(
                    new Cached(
                        $container->get(ClientInterface::class),
                        $container->get(CacheInterface::class),
                        3600
                    ),
                    $app->getErrorHandler(),
                    $container->get(ResponseFactoryInterface::class)
                ),
                $container->get(RequestFactoryInterface::class),
                $app->params['deworker_api_url']
            );
        });
    }
}
