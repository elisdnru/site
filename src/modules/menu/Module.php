<?php

namespace app\modules\menu;

use app\components\module\Module as Base;

class Module extends Base
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Структура';
    }

    public function getName(): string
    {
        return 'Меню';
    }
}
