<?php

namespace app\modules\file;

use app\components\system\WebModule;

class Module extends WebModule
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
