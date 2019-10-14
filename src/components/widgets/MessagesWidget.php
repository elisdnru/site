<?php

namespace app\components\widgets;

class MessagesWidget extends Widget
{
    public function run(): void
    {
        $this->render('Messages');
    }
}
