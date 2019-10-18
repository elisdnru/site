<?php

namespace app\components\widgets;

use CWidget;

class MessagesWidget extends CWidget
{
    public function run(): void
    {
        $this->render('Messages');
    }
}
