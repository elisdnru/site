<?php

declare(strict_types=1);

namespace yii\di;

use yii\base\Component;

class Container extends Component
{
    /**
     * @param string|Instance $class
     * @param array $params
     * @param array $config
     * @return object
     * @template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public function get($class, $params = [], $config = [])
    {
        /**
         * @psalm-suppress MixedMethodCall
         */
        return new $class();
    }
}
