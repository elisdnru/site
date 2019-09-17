<?php

namespace app\components\module;

use CBehavior;
use Yii;

class ModuleAccessBehavior extends CBehavior
{
    public function moduleAllowed($module)
    {
        return Yii::app()->moduleManager->allowed($module);
    }
}
