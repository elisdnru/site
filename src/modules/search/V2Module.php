<?php

namespace app\modules\search;

use app\components\module\v2\Module as Base;
use app\components\module\routes\UrlProvider;

class V2Module extends Base implements UrlProvider
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

    public static function rulesPriority(): int
    {
        return 0;
    }
}
