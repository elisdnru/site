<?php

namespace app\modules\main\widgets;

use app\modules\main\components\widgets\Widget;

class MessagesWidget extends Widget
{
    public function run()
    {
        $this->render('Messages');
    }
}
