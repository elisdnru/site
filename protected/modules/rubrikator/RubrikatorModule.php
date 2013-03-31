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
        return 'Рубрикатор';
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


    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'RUBRIKATOR.ITEMS_PER_PAGE',
                'label'=>'Статей на странице',
                'value'=>'',
                'type'=>'string',
                'default'=>'10',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'RUBRIKATOR.ITEMS_PER_PAGE',
        ));

        return parent::uninstall();
    }
}
