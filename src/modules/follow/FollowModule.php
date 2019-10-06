<?php

namespace app\modules\follow;

use app\components\system\WebModule;

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
