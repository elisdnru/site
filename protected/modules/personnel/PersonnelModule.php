<?php

class PersonnelModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.personnel.components.*',
            'application.modules.personnel.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Персонал';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Категории', 'url'=>array('/personnel/categoryAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Сотрудники', 'url'=>array('/personnel/employeeAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить сотрудника', 'url'=>array('/personnel/employeeAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'personnel/<category:[\w_\/-]+>/<id:[\d]+>/<alias:[\w_-]+>'=>'personnel/employee/show',
            'personnel/<id:[\d]+>'=>'personnel/employee/show',
            'personnel/<category:[\w_\/-]+>/page-<page:\d+>'=>'personnel/default/category',
            'personnel/page-<page:\d+>'=>'personnel/default/index',
            'personnel/<category:[\w_\/-]+>'=>'personnel/default/category',
            'personnel'=>'personnel/default/index',
        );
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/modules/personnel.css');
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'PERSONNEL.ITEMS_PER_PAGE',
                'label'=>'Сотрудников на странице',
                'value'=>'9',
                'type'=>'string',
                'default'=>'9',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'PERSONNEL.ITEMS_PER_PAGE',
        ));

        return parent::uninstall();
    }
}
