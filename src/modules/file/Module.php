<?php

declare(strict_types=1);

namespace app\modules\file;

use app\components\module\admin\AdminMenuProvider;
use yii\base\Module as Base;

final class Module extends Base implements AdminMenuProvider
{
    public function adminGroup(): string
    {
        return 'Загрузки';
    }

    public function adminName(): string
    {
        return 'Файлы';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Файлы', 'url' => ['/file/admin/file/index'], 'icon' => 'fileicon.jpg'],
        ];
    }
}
