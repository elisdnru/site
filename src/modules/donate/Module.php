<?php

declare(strict_types=1);

namespace app\modules\donate;

use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use Override;
use yii\base\Module as Base;
use yii\helpers\Url;

final class Module extends Base implements RoutesProvider, SitemapProvider
{
    #[Override]
    public static function routes(): array
    {
        return [
            'donate' => 'donate/default/index',
        ];
    }

    #[Override]
    public static function routesPriority(): int
    {
        return 0;
    }

    #[Override]
    public static function sitemap(): array
    {
        return [
            new Group('Страницы', [
                new Item(
                    Url::to(['/donate/default/index']),
                    'Поддержать проект',
                    null,
                    []
                ),
            ]),
        ];
    }

    #[Override]
    public static function sitemapPriority(): int
    {
        return 20;
    }
}
