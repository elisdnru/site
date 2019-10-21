<?php

namespace app\components\widgets;

use yii\base\Widget;

class MessagesWidget extends Widget
{
    public function run(): string
    {
        return $this->render('Messages');
    }
}
