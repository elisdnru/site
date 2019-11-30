<?php

namespace app\widgets;

use yii\base\Widget;

class FollowWidget extends Widget
{
    public function run(): string
    {
        return $this->render('Follow');
    }
}
