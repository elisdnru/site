<?php

namespace app\components\module;

use Yii;

class ModuleAccess
{
    public function isGranted(string $module): bool
    {
        return Yii::$app->user->can('module_' . $module);
    }
}
