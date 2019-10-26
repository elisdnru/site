<?php

namespace app\modules\portfolio;

use app\components\GroupUrlRule;
use app\components\module\routes\UrlProvider;
use CWebModule;

class Module extends CWebModule implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'portfolio',
                'rules' => [
                    '<category:[\w_\/-]+>/<id:[\d]+>/<alias:.+>' => 'work/show',
                    '<category:[\w_\/-]+>/<id:[\d]+>' => 'work/show',
                    '<id:[\d]+>' => 'work/show',
                    '<category:[\w_\/-]+>/page-<page:\d+>' => 'default/category',
                    'page-<page:\d+>' => 'default/index',
                    '<category:[\w_\/-]+>' => 'default/category',
                    '' => 'default/index',
                ],
            ],
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
