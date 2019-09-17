<?php

namespace app\modules\menu\widgets;

use app\components\module\UrlRulesHelper;
use app\modules\main\components\widgets\Widget;
use app\modules\menu\models\Menu;
use Yii;

UrlRulesHelper::import('menu');

class MenuWidget extends Widget
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
