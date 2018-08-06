<?php

Yii::import('application.modules.menu.models.*');
DUrlRulesHelper::import('menu');

class MenuWidget extends DWidget
{
    public $parent;

    public function run()
    {
        $className = 'zii.widgets.CMenu';
        $className = Yii::import($className, true);
        $widget = new $className();
        $widget->items = Menu::model()->getArray($this->parent);
        $widget->run();
    }
}
