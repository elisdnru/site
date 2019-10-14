<?php

namespace app\extensions\cachetagging;

use CBehavior;

class TaggingBehavior extends CBehavior
{
    const PREFIX = '__tag__';

    public function clear($tags): void
    {

        foreach ((array)$tags as $tag) {
            $this->owner->set(self::PREFIX . $tag, time());
        }
    }
}
