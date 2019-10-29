<?php

namespace app\modules\portfolio;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;
use yii\web\GroupUrlRule;

class Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Контент';
    }

    public function getName(): string
    {
        return 'Портфолио';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications(): array
    {
        return [];
    }

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
