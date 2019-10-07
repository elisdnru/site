<?php

namespace app\modules\portfolio;

use app\components\GroupUrlRule;
use app\components\system\WebModule;
use Yii;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

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
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'portfolio',
                'rules' => [
                    '<category:[\w_\/-]+>/<id:[\d]+>/<alias:[\w_-]+>' => 'work/show',
                    '<id:[\d]+>' => 'work/show',
                    '<category:[\w_\/-]+>/page-<page:\d+>' => 'default/category',
                    'page-<page:\d+>' => 'default/index',
                    '<category:[\w_\/-]+>' => 'default/category',
                    '' => 'default/index',
                ],
            ],
        ];
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerPackage('portfolio');
    }
}
