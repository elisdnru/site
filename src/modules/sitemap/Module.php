<?php

namespace app\modules\sitemap;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;

class Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Карта сайта';
    }

    public static function rules(): array
    {
        return [
            'sitemap' => 'sitemap/default/index',
            ['sitemap/default/xml', 'pattern' => 'sitemap.xml', 'urlSuffix' => ''],
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
