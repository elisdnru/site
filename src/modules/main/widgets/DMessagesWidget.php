<?php

namespace app\modules\main\widgets;

use app\modules\main\components\widgets\DWidget;

class DMessagesWidget extends DWidget
{
    public function run()
    {
        $this->render('Messages');
    }
}
