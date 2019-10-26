<?php

namespace app\components\module;

use Yii;

class ModuleManager
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

    private function getModuleClass(string $name): string
    {
        $modules = Yii::$app->getModules();
        $module = $modules[$name] ?? null;

        if ($module !== null && is_object($module)) {
            return get_class($module);
        }
        if ($module !== null && is_array($module)) {
            return $module['class'];
        }

        throw new \InvalidArgumentException('Cannot detect module class ' . $name);
    }
}
