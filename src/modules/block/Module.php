<?php

namespace app\modules\block;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\Module as Base;

class Module extends Base implements AdminMenuProvider
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
}
