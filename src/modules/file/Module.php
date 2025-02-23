<?php

declare(strict_types=1);

namespace app\modules\file;

use app\components\module\admin\AdminMenuProvider;
use Override;
use yii\base\Module as Base;

final class Module extends Base implements AdminMenuProvider
{
    #[Override]
    public function adminGroup(): string
    {
        return 'Загрузки';
    }

    #[Override]
    public function adminName(): string
    {
        return 'Файлы';
    }

    #[Override]
    public static function adminMenu(): array
    {
        return [
            ['label' => 'Файлы', 'url' => ['/file/admin/file/index'], 'icon' => 'fileicon.jpg'],
        ];
    }
}
