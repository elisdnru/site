<?php

namespace app\modules\menu;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup()
    {
        return 'Структура';
    }

    public function getName()
    {
        return 'Меню';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Пункты', 'url' => ['/menu/admin/menu/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить пункт', 'url' => ['/menu/admin/menu/create'], 'icon' => 'add.png'],
        ];
    }
}
