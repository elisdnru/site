<?php

namespace app\modules\home;

use app\components\module\routes\UrlProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use yii\base\Module as Base;
use yii\helpers\Url;

class Module extends Base implements UrlProvider, SitemapProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            '' => 'home/default/index',
            'error' => 'home/default/error',
        ];
    }

    public static function rulesPriority(): int
    {
        return 100;
    }

    public static function sitemap(): array
    {
        return [
            new Group('Страницы', [
                new Item(
                    Url::to(['/home/default/index']),
                    'Дмитрий Елисеев',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                )
            ])
        ];
    }

    public static function sitemapPriority(): int
    {
        return 100;
    }
}
