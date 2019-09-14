<?php

namespace app\modules\main\widgets;

use DWidget;

class DMessagesWidget extends DWidget
{
    public function run()
    {
        $this->render('Messages');
    }
}
