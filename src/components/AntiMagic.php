<?php

declare(strict_types=1);

namespace app\components;

use yii\base\InvalidCallException;
use yii\base\UnknownMethodException;
use yii\base\UnknownPropertyException;

trait AntiMagic
{
    public function __get(string $name): mixed
    {
        throw new UnknownPropertyException('Getting unknown property: ' . static::class . '::' . $name);
    }

    public function __set(string $name, mixed $value): void
    {
        throw new UnknownPropertyException('Setting unknown property: ' . static::class . '::' . $name);
    }

    public function __isset(string $name): bool
    {
        return false;
    }

    public function __unset(string $name): void
    {
        throw new InvalidCallException('Unsetting unknown property: ' . static::class . '::' . $name);
    }

    public function __call(string $name, array $params): mixed
    {
        throw new UnknownMethodException('Calling unknown method: ' . static::class . "::{$name}()");
    }
}
