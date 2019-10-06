<?php

namespace app\modules\search;

use app\modules\main\components\system\WebModule;

class SearchModule extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Поиск';
    }

    public static function rules()
    {
        return [
            'search' => 'search/default/index',
        ];
    }
}
