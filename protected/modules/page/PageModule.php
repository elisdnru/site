<?php

class PageModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.page.components.*',
            'application.modules.page.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Страницы';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Шаблоны', 'url'=>array('/page/layoutAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Страницы', 'url'=>array('/page/pageAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить страницу', 'url'=>array('/page/pageAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'page/page/show'=>'site/error',
            'page/page'=>'site/error',
            array('class' => 'page.components.DPageUrlRule', 'cache'=>3600*24),
        );
    }
}
