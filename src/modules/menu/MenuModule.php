<?php

class MenuModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.menu.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Структура';
    }

    public function getName()
    {
        return 'Меню';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Пункты', 'url'=>array('/menu/menuAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить пункт', 'url'=>array('/menu/menuAdmin/create'), 'icon'=>'add.png'),
        );
    }
}
