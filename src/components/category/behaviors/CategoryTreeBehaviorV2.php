<?php

namespace app\components\category\behaviors;

use yii\base\NotSupportedException;

class CategoryTreeBehaviorV2 extends CategoryBehavior
{
    public function getPath(string $separator = '/'): string
    {
        throw new NotSupportedException('Incomplete error.');
    }
}
