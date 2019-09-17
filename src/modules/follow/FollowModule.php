<?php

namespace app\modules\follow;

use app\modules\main\components\system\WebModule;

class FollowModule extends WebModule
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
