<?php

class DModuleManager extends CApplicationComponent
{
    public function allowed($module)
    {
        return Yii::app()->user->checkAccess('module_' . $module);
    }

    public function notifications($module)
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'notifications') ? call_user_func($class . '::notifications') : [];
        }
        return [];
    }

    public function rules($module)
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'rules') ? call_user_func($class . '::rules') : [];
        }
        return [];
    }

    public function adminMenu($module)
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'adminMenu') ? call_user_func($class . '::adminMenu') : [];
        }
        return [];
    }

    private function getModuleClass($module)
    {
        if (isset(Yii::app()->modules[$module])) {
            return Yii::app()->modules[$module]['class'];
        }

        return '';
    }
}
