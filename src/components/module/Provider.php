<?php

declare(strict_types=1);

namespace app\components\module;

use Yii;
use yii\base\BootstrapInterface;

final class Provider implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(Modules::class, static fn () => new Modules($app));
    }
}
