<?php

class PortfolioModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.portfolio.components.*',
            'application.modules.portfolio.models.*',
        ]);
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
        return [
            ['label' => 'Категории', 'url' => ['/portfolio/categoryAdmin/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Работы', 'url' => ['/portfolio/workAdmin/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить работу', 'url' => ['/portfolio/workAdmin/create'], 'icon' => 'add.png'],
        ];
    }

    public static function rules()
    {
        return [
            'portfolio/<category:[\w_\/-]+>/<id:[\d]+>/<alias:[\w_-]+>' => 'portfolio/work/show',
            'portfolio/<id:[\d]+>' => 'portfolio/work/show',
            'portfolio/<category:[\w_\/-]+>/page-<page:\d+>' => 'portfolio/default/category',
            'portfolio/page-<page:\d+>' => 'portfolio/default/index',
            'portfolio/<category:[\w_\/-]+>' => 'portfolio/default/category',
            'portfolio' => 'portfolio/default/index',
        ];
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/modules/portfolio.css');
    }
}
