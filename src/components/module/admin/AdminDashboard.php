<?php

declare(strict_types=1);

namespace app\components\module\admin;

use app\components\module\Modules;

class AdminDashboard
{
    private AdminAccess $access;
    private Modules $modules;

    public function __construct(AdminAccess $access, Modules $modules)
    {
        $this->access = $access;
        $this->modules = $modules;
    }

    public function groupedModules(): array
    {
        $modules = [];

        foreach ($this->modules->definitions() as $key => $value) {
            $module = $this->modules->load($key);
            if ($module instanceof AdminDashboardItem && $this->access->isGranted($module->id)) {
                $modules[$module->adminGroup()][$module->adminName()] = $module;
            }
        }

        ksort($modules);

        return $modules;
    }
}
