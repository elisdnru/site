<?php

class GraduateModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.graduate.components.*',
            'application.modules.graduate.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Выпускники';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Классы', 'url'=>array('/graduate/gradeAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Выпускники', 'url'=>array('/graduate/graduateAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Импорт списка', 'url'=>array('/graduate/graduateAdmin/importList'), 'icon'=>'add.png'),
            array('label'=>'Добавить выпускника', 'url'=>array('/graduate/graduateAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'graduate/rewards'=>'graduate/default/rewards',
            'graduate/<year:\d+>'=>'graduate/default/year',
            'graduate'=>'graduate/default/index',
        );
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/modules/graduate.css');
    }
}
