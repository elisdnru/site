<?php

namespace app\components\colorbox\widgets;

use app\components\colorbox\ColorboxAsset;
use app\components\widgets\Widget;
use Yii;

class ColorboxWidget extends Widget
{
    public function run(): void
    {
        ColorboxAsset::register(Yii::$app->view);
    }
}
