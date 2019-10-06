<?php

namespace app\components\behaviors;

use CBehavior;

class HeadersBehavior extends CBehavior
{
    public function initHeaders()
    {
        header('X-Programmer: ElisDN');
    }
}
