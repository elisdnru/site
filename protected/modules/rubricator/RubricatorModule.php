<?php

class RubricatorModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.rubricator.models.*',
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
            array('label'=>'Рубрики', 'url'=>array('/rubricator/categoryAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Статьи', 'url'=>array('/rubricator/articleAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить статью', 'url'=>array('/rubricator/articleAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'rubricator'=>'rubricator/default/index',
            'rubricator/all'=>'rubricator/default/index',
            'rubricator/<category:[\w_-]+>/<id:\d+>/<alias:[\w_-]+>'=>'rubricator/article/show',
            'rubricator/<category:[\w_-]+>'=>'rubricator/default/category',
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'RUBRICATOR.ITEMS_PER_PAGE',
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
            'RUBRICATOR.ITEMS_PER_PAGE',
        ));

        return parent::uninstall();
    }
}
