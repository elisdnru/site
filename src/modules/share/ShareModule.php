<?php

namespace app\modules\share;

use app\modules\main\components\system\WebModule;

class ShareModule extends WebModule
{
    public function getGroup()
    {
        return 'Прочее';
    }

    public function getName()
    {
        return 'Поделиться';
    }
}
