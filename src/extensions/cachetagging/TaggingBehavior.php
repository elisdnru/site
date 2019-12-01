<?php

namespace app\extensions\cachetagging;

use CBehavior;
use CComponent;
use ICache;

class TaggingBehavior extends CBehavior
{
    public const PREFIX = '__tag__';

    public function clear($tags): void
    {
        foreach ((array)$tags as $tag) {
            $this->getCache()->set(self::PREFIX . $tag, time());
        }
    }

    /**
     * @return ICache|CComponent
     */
    private function getCache(): ICache
    {
        return $this->owner;
    }
}
