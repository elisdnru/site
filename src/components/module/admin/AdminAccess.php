<?php

namespace app\components\module\admin;

use Yii;

class AdminAccess
{
    public function isGranted(string $module): bool
    {
        return Yii::$app->user->can('module_' . $module);
    }
}
