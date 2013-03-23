<?php

class BlockModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'block.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Настройки и шаблоны';
    }

    public function getName()
    {
        return 'HTML-блоки';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Блоки', 'url'=>array('/block/blockAdmin/index'), 'icon'=>'code.png'),
            array('label'=>'Добавить блок', 'url'=>array('/block/blockAdmin/create'), 'icon'=>'add.png'),
        );
    }
}
