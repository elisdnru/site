<?php

namespace app\modules\block;

use app\components\module\Module as Base;

class Module extends Base
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Настройки и шаблоны';
    }

    public function getName(): string
    {
        return 'HTML-блоки';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Блоки', 'url' => ['/block/admin/block/index'], 'icon' => 'code.png'],
            ['label' => 'Добавить блок', 'url' => ['/block/admin/block/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications(): array
    {
        return [];
    }
}
