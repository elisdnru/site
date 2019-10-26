<?php

namespace app\modules\file;

use app\components\module\Module as Base;

class Module extends Base
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Загрузки';
    }

    public function getName(): string
    {
        return 'Файлы';
    }
}
