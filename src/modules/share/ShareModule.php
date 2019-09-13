<?php

namespace app\modules\share;

use app\modules\main\components\system\DWebModule;

class ShareModule extends DWebModule
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
