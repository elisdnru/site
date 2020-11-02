<?php

namespace app\modules\file;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\Module as Base;

class Module extends Base implements AdminMenuProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Загрузки';
    }

    public function getName(): string
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
