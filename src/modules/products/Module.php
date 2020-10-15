<?php

namespace app\modules\products;

use app\components\module\routes\UrlProvider;
use app\components\module\Module as Base;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use yii\helpers\Url;

class Module extends Base implements UrlProvider, SitemapProvider
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

    public static function sitemap(): array
    {
        return [
            new Group('Страницы', [
                new Item(
                    Url::to(['/products/default/index']),
                    'Авторские продукты',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                )
            ])
        ];
    }

    public static function sitemapPriority(): int
    {
        return 90;
    }
}
