<?php

namespace app\components\colorbox\widgets;

use app\components\colorbox\ColorboxAsset;
use CWidget;
use Yii;

class ColorboxWidget extends CWidget
{
    public function run(): void
    {
        ColorboxAsset::register(Yii::$app->view);
    }
}
