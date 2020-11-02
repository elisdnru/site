<?php

namespace app\modules\sitemap;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;

class Module extends Base implements RoutesProvider
{
    public static function routes(): array
    {
        return [
            'sitemap' => 'sitemap/default/index',
            [
                'pattern' => 'sitemap.xml',
                'route' => 'sitemap/default/xml',
                'suffix' => ''
            ],
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
