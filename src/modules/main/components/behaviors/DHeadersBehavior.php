<?php

namespace app\modules\main\components\behaviors;

use CBehavior;

class DHeadersBehavior extends CBehavior
{
    public function initHeaders()
    {
        header('X-Programmer: ElisDN');
    }
}
