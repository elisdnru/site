<?php

class PortfolioModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'portfolio.components.*',
            'portfolio.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Портфолио';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Категории', 'url'=>array('/portfolio/categoryAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Работы', 'url'=>array('/portfolio/workAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить работу', 'url'=>array('/portfolio/workAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'portfolio/<category:[\w_\/-]+>/<id:[\d]+>/<alias:[\w_-]+>'=>'portfolio/work/show',
            'portfolio/<id:[\d]+>'=>'portfolio/work/show',
            'portfolio/<category:[\w_\/-]+>/page-<page:\d+>'=>'portfolio/default/category',
            'portfolio/page-<page:\d+>'=>'portfolio/default/index',
            'portfolio/<category:[\w_\/-]+>'=>'portfolio/default/category',
            'portfolio'=>'portfolio/default/index',
        );
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/modules/portfolio.css');
    }
}
