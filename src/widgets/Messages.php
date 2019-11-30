<?php

namespace app\widgets;

use yii\base\Widget;

class Messages extends Widget
{
    public function run(): string
    {
        return $this->render('Messages');
    }
}
