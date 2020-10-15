<?php

namespace app\modules\products;

use app\components\module\routes\UrlProvider;
use app\components\module\Module as Base;

class Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Продукты';
    }

    public static function adminMenu(): array
    {
        return [];
    }

    public static function notifications(): array
    {
        return [];
    }

    public static function rules(): array
    {
        return [
            'products' => 'products/default/index',
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
