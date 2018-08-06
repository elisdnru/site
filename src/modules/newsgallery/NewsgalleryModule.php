<?php

class NewsgalleryModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.newsgallery.models.*',
        ]);
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Загрузки';
    }

    public function getName()
    {
        return 'Галереи для новостей';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Галереи', 'url' => ['/newsgallery/galleryAdmin/index'], 'icon' => 'images.png'],
            ['label' => 'Добавить галерею', 'url' => ['/newsgallery/galleryAdmin/create'], 'icon' => 'add.png'],
        ];
    }
}
