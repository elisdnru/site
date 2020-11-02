<?php

namespace app\components\module\admin;

use Yii;

class AdminMenu
{
    public function menu(string $module): array
    {
        $class = ModuleClass::getClass(Yii::$app->getModules(), $module);

        if (!is_subclass_of($class, AdminMenuProvider::class)) {
            return [];
        }

        /** @var AdminMenuProvider $class */
        return $class::adminMenu();
    }
}
