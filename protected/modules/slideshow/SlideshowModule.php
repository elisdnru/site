<?php

class SlideshowModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'slideshow.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Слайдшоу';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Слайды', 'url'=>array('/slideshow/slideAdmin/index'), 'icon'=>'images.png'),
            array('label'=>'Добавить слайд', 'url'=>array('/slideshow/slideAdmin/create'), 'icon'=>'add.png'),
        );
    }
}
