<?php

namespace app\modules\follow;

use DWebModule;

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
