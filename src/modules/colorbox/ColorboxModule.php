<?php

namespace app\modules\colorbox;

use app\modules\main\components\system\DWebModule;

class ColorboxModule extends DWebModule
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
