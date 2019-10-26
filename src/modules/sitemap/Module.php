<?php

namespace app\modules\sitemap;

use app\components\module\routes\UrlProvider;
use CWebModule;

class Module extends CWebModule implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

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
