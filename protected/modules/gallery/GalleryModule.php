<?php

class GalleryModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'gallery.models.*',
        ));
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
        return 'Галереи';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Галереи', 'url'=>array('/gallery/galleryAdmin/index'), 'icon'=>'images.png'),
            array('label'=>'Добавить галерею', 'url'=>array('/gallery/galleryAdmin/create'), 'icon'=>'add.png'),
        );
    }
}
