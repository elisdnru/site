<?php

declare(strict_types=1);

namespace yii\di;

use yii\base\Component;

class Container extends Component
{
    /**
     * @template T
     * @param class-string<T> $class
     * @param array $params
     * @param array $config
     * @return T
     */
    public function get($class, $params = [], $config = [])
    {
        /**
         * @psalm-suppress MixedMethodCall
         */
        return new $class();
    }
}
