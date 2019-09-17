<?php

namespace app\modules\menu\widgets;

use app\components\module\UrlRulesHelper;
use CHtml;
use app\modules\main\components\widgets\Widget;

UrlRulesHelper::import('menu');

class TableMenuWidget extends Widget
{
    public $items = [];

    public function run()
    {
        echo CHtml::openTag('table');

        foreach ($this->items as $item) {
            echo CHtml::openTag('td', ['class' => $item['active'] ? 'active' : '']);
            echo CHtml::link(CHtml::encode($item['label']), $item['url']);
            echo CHtml::closeTag('td');
        }

        echo CHtml::closeTag('table');
    }
}
