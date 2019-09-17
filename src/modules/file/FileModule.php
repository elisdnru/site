<?php

namespace app\modules\file;

use app\modules\main\components\system\WebModule;

class FileModule extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.file.models.*',
        ]);
    }

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
            ['label' => 'Файлы', 'url' => ['/file/fileAdmin/index'], 'icon' => 'fileicon.jpg'],
        ];
    }
}
