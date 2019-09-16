<?php

namespace app\modules\follow\widgets;

use CHtml;
use app\modules\main\components\widgets\DWidget;
use Yii;

class FollowWidget extends DWidget
{
    public function run()
    {
        $this->render('Follow');
    }
}
