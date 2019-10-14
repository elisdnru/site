<?php

namespace app\components\module;

use CApplicationComponent;
use Yii;

class ModuleManager extends CApplicationComponent
{
    public function allowed(string $module): bool
    {
        return Yii::app()->user->checkAccess('module_' . $module);
    }

    public function notifications(string $module): array
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'notifications') ? call_user_func($class . '::notifications') : [];
        }
        return [];
    }

    public function adminMenu(string $module): array
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'adminMenu') ? call_user_func($class . '::adminMenu') : [];
        }
        return [];
    }

    private function getModuleClass(string $module): string
    {
        return Yii::app()->modules[$module]['class'] ?? '';
    }
}
