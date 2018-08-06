<?php

class DModuleManager extends CApplicationComponent
{
    protected $modules = [];

    public function init()
    {
        $this->modules = [];

        if (Yii::app()->db->schema->getTable('{{module}}')) {
            $rows = Yii::app()->db->cache(0, new Tags('module'))->createCommand('SELECT * FROM {{module}}')->queryAll();

            foreach ($rows as $row) {
                $this->modules[$row['module']] = [
                    'installed' => $row['installed'],
                    'system' => $row['system'],
                    'active' => $row['active'],
                ];
            }
        }
    }

    public function system($module)
    {
        if (!isset($this->modules[$module])) {
            if ($class = $this->getModuleClass($module)) {
                $system = call_user_func($class . '::system');
            } else {
                $system = 0;
            }


            $this->modules[$module]['system'] = $system;
            $this->modules[$module]['active'] = $system;
            $this->modules[$module]['installed'] = $system;
        }

        return isset($this->modules[$module]['system']) ? $this->modules[$module]['system'] : 0;
    }

    public function installed($module)
    {
        if ($this->system($module)) {
            return true;
        }

        return isset($this->modules[$module]['installed']) ? $this->modules[$module]['installed'] : 0;
    }

    public function active($module)
    {
        if ($this->system($module)) {
            return true;
        }

        return isset($this->modules[$module]['active']) ? $this->modules[$module]['active'] : 0;
    }

    public function allowed($module)
    {
        return $this->active($module) && Yii::app()->user->checkAccess('module_' . $module);
    }

    public function notifications($module)
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'notifications') ? call_user_func($class . '::notifications') : [];
        } else {
            return [];
        }
    }

    public function rules($module)
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'rules') ? call_user_func($class . '::rules') : [];
        } else {
            return [];
        }
    }

    public function adminMenu($module)
    {
        if ($class = $this->getModuleClass($module)) {
            return method_exists($class, 'adminMenu') ? call_user_func($class . '::adminMenu') : [];
        } else {
            return [];
        }
    }

    public function getModuleClass($module)
    {
        if (isset(Yii::app()->modules[$module])) {
            $alias = Yii::app()->modules[$module]['class'];

            if (empty($alias)) {
                $alias = ucfirst($module) . 'Module';
            }

            Yii::import($alias);

            $domains = explode('.', $alias);
            $class = array_pop($domains);
        } else {
            $class = '';
        }

        return $class;
    }

    public function install($moduleName)
    {
        if ($moduleName && Yii::app()->hasModule($moduleName)) {
            $module = Yii::app()->getModule($moduleName);

            if ($module->install()) {
                Yii::app()->db
                    ->createCommand('DELETE FROM {{module}} WHERE module = :module')
                    ->execute([
                        ':module' => $module->id,
                    ]);

                Yii::app()->db
                    ->createCommand('INSERT INTO {{module}} (module, system, installed, active) VALUES (:module, :system, :installed, :active)')
                    ->execute([
                        ':module' => $module->id,
                        ':installed' => 1,
                        ':system' => $this->system($module->id),
                        ':active' => $this->system($module->id),
                    ]);

                $this->modules[$moduleName] = [
                    'installed' => 1,
                    'system' => $this->system($module->id),
                    'active' => $this->system($module->id),
                ];

                return true;
            }
        }
        return false;
    }

    public function uninstall($moduleName)
    {
        if ($moduleName && Yii::app()->hasModule($moduleName) && $this->installed($moduleName)) {
            $module = Yii::app()->getModule($moduleName);

            if ($module->uninstall()) {
                Yii::app()->db
                    ->createCommand('DELETE FROM {{module}} WHERE `module` = :module')
                    ->execute([':module' => $module->getId()]);

                unset($this->modules[$moduleName]);

                return true;
            }
        }
        return false;
    }

    public function activate($moduleName)
    {
        if ($moduleName && Yii::app()->hasModule($moduleName) && $this->installed($moduleName)) {
            Yii::app()->db
                ->createCommand('UPDATE {{module}} SET `active` = :active WHERE `module` = :module')
                ->execute([
                    ':module' => $moduleName,
                    ':active' => 1,
                ]);

            $this->modules[$moduleName]['active'] = 1;

            return true;
        }
        return false;
    }

    public function deactivate($moduleName)
    {
        if ($moduleName && Yii::app()->hasModule($moduleName) && $this->installed($moduleName)) {
            Yii::app()->db
                ->createCommand('UPDATE {{module}} SET `active` = :active WHERE `module` = :module')
                ->execute([
                    ':module' => $moduleName,
                    ':active' => 0,
                ]);

            $this->modules[$moduleName]['active'] = 0;

            return true;
        }
        return false;
    }
}
