<?php

namespace app\modules\page;

use app\modules\main\components\system\WebModule;

class PageModule extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.page.components.*',
            'application.modules.page.models.*',
        ]);
    }

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
