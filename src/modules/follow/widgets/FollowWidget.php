<?php

namespace app\modules\follow\widgets;

use app\components\widgets\Widget;

class FollowWidget extends Widget
{
    public function run()
    {
        $this->render('Follow');
    }
}
