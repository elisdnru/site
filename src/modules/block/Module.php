<?php

declare(strict_types=1);

namespace app\modules\block;

use app\components\module\admin\AdminMenuProvider;
use Override;
use yii\base\Module as Base;

final class Module extends Base implements AdminMenuProvider
{
    #[Override]
    public function adminGroup(): string
    {
        return 'Настройки и шаблоны';
    }

    #[Override]
    public function adminName(): string
    {
        return 'HTML-блоки';
    }

    #[Override]
    public static function adminMenu(): array
    {
        return [
            ['label' => 'Блоки', 'url' => ['/block/admin/block/index'], 'icon' => 'code.png'],
            ['label' => 'Добавить блок', 'url' => ['/block/admin/block/create'], 'icon' => 'add.png'],
        ];
    }
}
