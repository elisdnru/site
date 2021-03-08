<?php

declare(strict_types=1);

namespace app\components;

use yii\base\InvalidCallException;
use yii\base\UnknownMethodException;
use yii\base\UnknownPropertyException;

trait AntiMagic
{
    public function __get(string $name)
    {
        throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __set(string $name, mixed $value)
    {
        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __isset(string $name): bool
    {
        return false;
    }

    public function __unset(string $name)
    {
        throw new InvalidCallException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
    }

    public function __call(string $name, array $params)
    {
        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }
}
