<?php

namespace app\modules\menu;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Структура';
    }

    public function getName(): string
    {
        return 'Меню';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Пункты', 'url' => ['/menu/admin/menu/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить пункт', 'url' => ['/menu/admin/menu/create'], 'icon' => 'add.png'],
        ];
    }
}
