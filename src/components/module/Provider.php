<?php

declare(strict_types=1);

namespace app\components\module;

use Override;
use Yii;
use yii\base\BootstrapInterface;

final class Provider implements BootstrapInterface
{
    #[Override]
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(Modules::class, static fn () => new Modules($app));
    }
}
