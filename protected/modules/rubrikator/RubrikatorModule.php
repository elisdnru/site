<?php

class RubrikatorModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'rubrikator.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Рубрикатор';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Рубрики', 'url'=>array('/rubrikator/categoryAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Статьи', 'url'=>array('/rubrikator/articleAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить статью', 'url'=>array('/rubrikator/articleAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'rubrikator'=>'rubrikator/default/index',
            'rubrikator/<category:[\w_-]+>/<id:\d+>/<alias:[\w_-]+>'=>'rubrikator/article/show',
            'rubrikator/<category:[\w_-]+>'=>'rubrikator/default/category',
        );
    }
}
