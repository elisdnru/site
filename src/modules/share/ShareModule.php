<?php

namespace app\modules\share;

use DWebModule;

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
