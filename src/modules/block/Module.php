<?php

namespace app\modules\block;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\admin\AdminDashboardItem;
use yii\base\Module as Base;

class Module extends Base implements AdminDashboardItem, AdminMenuProvider
{
    public function adminGroup(): string
    {
        return 'Настройки и шаблоны';
    }

    public function adminName(): string
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
