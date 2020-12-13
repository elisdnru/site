<?php

declare(strict_types=1);

namespace app\modules\edu\components;

use app\modules\edu\components\api\Api;
use app\modules\edu\components\api\client\Cached;
use app\modules\edu\components\api\client\Muted;
use Http\Client\Curl\Client;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\CacheInterface;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Container;
use Laminas\Diactoros\RequestFactory;
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

        $container->setSingleton(Api::class, static function (Container $container) use ($app) {
            /** @var CacheInterface $cache */
            $cache = $container->get(CacheInterface::class);
            return new Api(
                new Muted(
                    new Cached(
                        new Client(),
                        $cache,
                        3600
                    ),
                    $app->getErrorHandler(),
                    new ResponseFactory()
                ),
                new RequestFactory(),
                $app->params['deworker_api_url']
            );
        });
    }
}
