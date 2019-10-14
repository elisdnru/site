<?php

namespace app\modules\page;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Контент';
    }

    public function getName(): string
    {
        return 'Страницы';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Шаблоны', 'url' => ['/page/admin/layout/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Страницы', 'url' => ['/page/admin/page/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить страницу', 'url' => ['/page/admin/page/create'], 'icon' => 'add.png'],
        ];
    }

    public static function rules(): array
    {
        return [
            'page/page/show' => 'site/error',
            'page/page' => 'site/error',
            ['class' => components\PageUrlRule::class, 'cache' => 3600 * 24],
        ];
    }
}
