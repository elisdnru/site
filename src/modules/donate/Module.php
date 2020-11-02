<?php

namespace app\modules\donate;

use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use yii\base\Module as Base;
use yii\helpers\Url;

class Module extends Base implements RoutesProvider, SitemapProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function routes(): array
    {
        return [
            'donate' => 'donate/default/index',
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }

    public static function sitemap(): array
    {
        return [
            new Group('Страницы', [
                new Item(
                    Url::to(['/donate/default/index']),
                    'Поддержать проект',
                    null,
                    []
                )
            ])
        ];
    }

    public static function sitemapPriority(): int
    {
        return 20;
    }
}
