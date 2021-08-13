<?php

declare(strict_types=1);

namespace app\modules\contacts;

use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use yii\base\Module as Base;
use yii\helpers\Url;

final class Module extends Base implements RoutesProvider, SitemapProvider
{
    public static function routes(): array
    {
        return [
            'contacts' => 'contacts/default/index',
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
                    Url::to(['/contacts/default/index']),
                    'Контактные данные',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                ),
            ]),
        ];
    }

    public static function sitemapPriority(): int
    {
        return 1;
    }
}
