<?php

declare(strict_types=1);

namespace tests\Module;

use Codeception\Module;
use Codeception\TestInterface;
use Yii;

/**
 * @psalm-api
 */
final class Cache extends Module
{
    public function _before(TestInterface $test): void
    {
        Yii::$app->cache?->flush();
    }
}
