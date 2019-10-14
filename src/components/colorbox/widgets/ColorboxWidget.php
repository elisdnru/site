<?php

namespace app\components\colorbox\widgets;

use CClientScript;
use CHtml;
use app\components\widgets\Widget;
use Yii;

class ColorboxWidget extends Widget
{
    public function run(): void
    {
        $cs = Yii::app()->getClientScript();

        $cs->registerCoreScript('jquery');

        $url = CHtml::asset(Yii::getPathOfAlias('application.components.colorbox.assets'));

        $cs->registerCssFile($url . '/colorbox.css');
        $cs->registerScriptFile($url . '/jquery.colorbox-min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($url . '/colorbox-begin.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($url . '/colorbox-end.js', CClientScript::POS_END);
    }
}
