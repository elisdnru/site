<?php

namespace app\modules\search;

use app\components\module\Module as Base;

class Module extends Base
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
