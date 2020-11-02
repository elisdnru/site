<?php

namespace app\modules\file;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\admin\AdminDashboardItem;
use yii\base\Module as Base;

class Module extends Base implements AdminDashboardItem, AdminMenuProvider
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
