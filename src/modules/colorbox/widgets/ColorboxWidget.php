<?php

namespace app\modules\colorbox\widgets;

use CClientScript;
use CHtml;
use DWidget;
use Yii;

class ColorboxWidget extends DWidget
{
    public function run()
    {
        $cs = Yii::app()->getClientScript();

        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile('jquery.easing.js');

        $url = CHtml::asset(Yii::getPathOfAlias('colorbox.assets'));

        $cs->registerCssFile($url . '/colorbox.css');
        $cs->registerScriptFile($url . '/jquery.colorbox-min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($url . '/colorbox-begin.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($url . '/colorbox-end.js', CClientScript::POS_END);
    }
}
