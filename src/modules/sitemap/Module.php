<?php

namespace app\modules\sitemap;

use app\components\module\Module as Base;

class Module extends Base
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
}
