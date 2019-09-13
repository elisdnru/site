<?php

namespace app\modules\follow;

use app\modules\main\components\system\DWebModule;

class FollowModule extends DWebModule
{
    public function getGroup()
    {
        return 'Прочее';
    }

    public function getName()
    {
        return 'Следуйте за мной';
    }
}
