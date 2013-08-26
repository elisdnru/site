<?php

class NewsgalleryModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.newsgallery.models.*',
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
        return 'Галереи для новостей';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Галереи', 'url'=>array('/newsgallery/galleryAdmin/index'), 'icon'=>'images.png'),
            array('label'=>'Добавить галерею', 'url'=>array('/newsgallery/galleryAdmin/create'), 'icon'=>'add.png'),
        );
    }
}
