<?php

namespace app\modules\block;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup()
    {
        return 'Настройки и шаблоны';
    }

    public function getName()
    {
        return 'HTML-блоки';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Блоки', 'url' => ['/block/admin/block/index'], 'icon' => 'code.png'],
            ['label' => 'Добавить блок', 'url' => ['/block/admin/block/create'], 'icon' => 'add.png'],
        ];
    }
}
