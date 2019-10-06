<?php

namespace app\modules\page;

use app\components\system\WebModule;

class PageModule extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Страницы';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Шаблоны', 'url' => ['/page/layoutAdmin/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Страницы', 'url' => ['/page/pageAdmin/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить страницу', 'url' => ['/page/pageAdmin/create'], 'icon' => 'add.png'],
        ];
    }

    public static function rules()
    {
        return [
            'page/page/show' => 'site/error',
            'page/page' => 'site/error',
            ['class' => components\PageUrlRule::class, 'cache' => 3600 * 24],
        ];
    }
}
