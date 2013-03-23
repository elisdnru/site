<?php

class DModuleManager extends CApplicationComponent
{
    protected $modules = array();

    public function init()
    {
        $this->modules = array();

        $rows = Yii::app()->db->cache(3600*24)->createCommand('SELECT * FROM {{module}}')->queryAll();

        foreach ($rows as $row){
            $this->modules[$row['module']] = array(
                'installed'=>$row['installed'],
                'system'=>0,
                'active'=>$row['active'],
            );
        }
    }

    public function system($module)
    {
        if (!isset($this->modules[$module]))
        {
            if ($class = $this->getModuleClass($module))
            {
                $system = call_user_func($class .'::system');
            }
            else
                $system = array();

            $this->modules[$module]['system'] = $system;
            $this->modules[$module]['active'] = $system;
            $this->modules[$module]['installed'] = $system;
        }

        return $this->modules[$module]['system'];
    }

    public function installed($module)
    {
        if ($this->system($module))
            return true;

        return isset($this->modules[$module]) ? $this->modules[$module]['installed'] : false;
    }

    public function active($module)
    {
        if ($this->system($module))
            return true;

        return isset($this->modules[$module]) ? $this->modules[$module]['active'] : false;
    }

    public function allowed($module)
    {
        return $this->active($module) && Yii::app()->user->checkAccess('module_' . $module);
    }

    public function notifications($module)
    {
        if ($class = $this->getModuleClass($module))
        {
            return method_exists($class, 'notifications') ? call_user_func($class .'::notifications') : array();
        }
        else
            return array();
    }

    public function rules($module)
    {
        if ($class = $this->getModuleClass($module))
        {
            return method_exists($class, 'rules') ? call_user_func($class .'::rules') : array();
        }
        else
            return array();
    }

    public function adminMenu($module)
    {
        if ($class = $this->getModuleClass($module))
            return  method_exists($class, 'adminMenu') ? call_user_func($class .'::adminMenu') : array();
        else
            return array();
    }

    public function getModuleClass($module)
    {
        if (isset(Yii::app()->modules[$module]))
        {
            $alias = Yii::app()->modules[$module]['class'];

            if (empty($alias))
                $alias = ucfirst($module) . 'Module';

            Yii::import($alias);

            $domains = explode('.', $alias);
            $class = array_pop($domains);
        }
        else
            $class = '';

        return $class;
    }

    public function install($moduleName)
    {
        if($moduleName && Yii::app()->hasModule($moduleName) && !$this->installed($moduleName))
        {
            $module = Yii::app()->getModule($moduleName);

            if ($module->install())
            {
                Yii::app()->db
                    ->createCommand('INSERT INTO {{module}} (`module`, `installed`, `active`) VALUES (:module, :installed, :active)')
                    ->execute(array(
                        ':module'=>$module->id,
                        ':installed'=>1,
                        ':active'=>0,
                    ));

                $this->modules[$moduleName] = array(
                    ':installed'=>1,
                    ':active'=>0,
                );

                return true;
            }
        }
        return false;
    }

    public function uninstall($moduleName)
    {
        if($moduleName && Yii::app()->hasModule($moduleName) && $this->installed($moduleName))
        {
            $module = Yii::app()->getModule($moduleName);

            if ($module->uninstall())
            {
                Yii::app()->db
                    ->createCommand('DELETE FROM {{module}} WHERE `module` = :module')
                    ->execute(array(':module'=>$module->getId()));

                unset($this->modules[$moduleName]);

                return true;
            }
        }
        return false;
    }

    public function activate($moduleName)
    {
        if($moduleName && Yii::app()->hasModule($moduleName) && $this->installed($moduleName))
        {
            Yii::app()->db
                ->createCommand('UPDATE {{module}} SET `active` = :active WHERE `module` = :module')
                ->execute(array(
                ':module'=>$moduleName,
                ':active'=>1,
            ));

            $this->modules[$moduleName]['active'] = 1;

            return true;
        }
        return false;
    }

    public function deactivate($moduleName)
    {
        if($moduleName && Yii::app()->hasModule($moduleName) && $this->installed($moduleName))
        {
            Yii::app()->db
                ->createCommand('UPDATE {{module}} SET `active` = :active WHERE `module` = :module')
                ->execute(array(
                ':module'=>$moduleName,
                ':active'=>0,
            ));

            $this->modules[$moduleName]['active'] = 0;

            return true;
        }
        return false;
    }
}
