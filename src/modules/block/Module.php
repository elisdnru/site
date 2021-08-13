<?php

declare(strict_types=1);

namespace app\modules\block;

use app\components\module\admin\AdminMenuProvider;
use yii\base\Module as Base;

final class Module extends Base implements AdminMenuProvider
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
