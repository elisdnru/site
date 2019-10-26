<?php

namespace app\modules\block;

use app\components\module\Module as Base;

class Module extends Base
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Настройки и шаблоны';
    }

    public function getName(): string
    {
        return 'HTML-блоки';
    }
}
