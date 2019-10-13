<?php

namespace app\modules\file;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup()
    {
        return 'Загрузки';
    }

    public function getName()
    {
        return 'Файлы';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Файлы', 'url' => ['/file/admin/file/index'], 'icon' => 'fileicon.jpg'],
        ];
    }
}
