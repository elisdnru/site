<?php

namespace app\components\widgets;

use CWidget;

class FollowWidget extends CWidget
{
    public function run(): void
    {
        $this->render('Follow');
    }
}
