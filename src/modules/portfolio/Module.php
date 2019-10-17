<?php

namespace app\modules\portfolio;

use app\components\GroupUrlRule;
use app\components\module\Module as Base;

class Module extends Base
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
}
