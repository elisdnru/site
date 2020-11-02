<?php

namespace app\components\module;

use yii\base\Module as Base;

abstract class Module extends Base
{
    public function getGroup(): string
    {
        return 'Прочее';
    }

    abstract public function getName(): string;
}
