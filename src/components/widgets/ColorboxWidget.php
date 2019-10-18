<?php

namespace app\components\widgets;

use app\assets\ColorboxAsset;
use CWidget;
use Yii;

class ColorboxWidget extends CWidget
{
    public function run(): void
    {
        ColorboxAsset::register(Yii::$app->view);
    }
}
