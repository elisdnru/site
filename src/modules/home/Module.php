<?php

declare(strict_types=1);

namespace app\modules\home;

use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use Override;
use yii\base\Module as Base;
use yii\helpers\Url;

final class Module extends Base implements RoutesProvider, SitemapProvider
{
    #[Override]
    public static function routes(): array
    {
        return [
            '' => 'home/default/index',
            'error' => 'home/default/error',
        ];
    }

    #[Override]
    public static function routesPriority(): int
    {
        return 100;
    }

    #[Override]
    public static function sitemap(): array
    {
        return [
            new Group('Страницы', [
                new Item(
                    Url::to(['/home/default/index']),
                    'Дмитрий Елисеев',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                ),
            ]),
        ];
    }

    #[Override]
    public static function sitemapPriority(): int
    {
        return 100;
    }
}
