<?php

namespace app\modules\blog;

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
                'prefix' => 'blog',
                'rules' => [
                    'feed' => 'feed/index',
                    'search' => 'default/search',
                    'tag/<tag:[\w-]+>/page-<page:\d+>' => 'default/tag',
                    'tag/<tag:[\w-]+>' => 'default/tag',
                    'date/<date:[\w-]+>/page-<page:\d+>' => 'default/date',
                    'date/<date:[\w-]+>' => 'default/date',
                    '<id:[\d]+>/<alias:.+>' => 'post/show',
                    '<id:[\d]+>' => 'post/show',
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
        return 98;
    }
}
