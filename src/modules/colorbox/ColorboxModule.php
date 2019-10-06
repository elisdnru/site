<?php

namespace app\modules\colorbox;

use app\components\system\WebModule;

class ColorboxModule extends WebModule
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
