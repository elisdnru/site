<?php

namespace app\modules\sitemap;

use app\components\module\v2\Module as Base;
use app\components\module\routes\UrlProvider;

class V2Module extends Base implements UrlProvider
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
            [
                'pattern' => 'sitemap.xml',
                'route' => 'sitemap/default/xml',
                'suffix' => ''
            ],
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
