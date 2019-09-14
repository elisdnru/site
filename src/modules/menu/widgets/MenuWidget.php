<?php

namespace app\modules\menu\widgets;

use app\components\module\DUrlRulesHelper;
use DWidget;
use app\modules\menu\models\Menu;
use Yii;

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
