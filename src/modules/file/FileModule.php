<?php

class FileModule extends DWebModule
{
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
