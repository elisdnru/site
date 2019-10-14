<?php

namespace app\modules\search;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Контент';
    }

    public function getName(): string
    {
        return 'Поиск';
    }

    public static function rules(): array
    {
        return [
            'search' => 'search/default/index',
        ];
    }
}
