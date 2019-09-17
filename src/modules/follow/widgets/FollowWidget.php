<?php

namespace app\modules\follow\widgets;

use CHtml;
use app\modules\main\components\widgets\Widget;
use Yii;

class FollowWidget extends Widget
{
    public function run()
    {
        $this->render('Follow');
    }
}
