<?php

declare(strict_types=1);

namespace app\components;

use yii\base\InvalidCallException;
use yii\base\UnknownMethodException;
use yii\base\UnknownPropertyException;

trait AntiMagic
{
    public function __get($name)
    {
        throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __set($name, $value)
    {
        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __isset($name): bool
    {
        return false;
    }

    public function __unset($name)
    {
        throw new InvalidCallException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
    }

    public function __call($name, $params)
    {
        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }
}
