<?php

declare(strict_types=1);

namespace app\components\module\admin;

use app\components\module\Modules;

final readonly class AdminDashboard
{
    private AdminAccess $access;
    private Modules $modules;

    /**
     * @psalm-api
     */
    public function __construct(AdminAccess $access, Modules $modules)
    {
        $this->access = $access;
        $this->modules = $modules;
    }

    public function groupedModules(): array
    {
        $modules = [];

        foreach (array_keys($this->modules->definitions()) as $name) {
            $module = $this->modules->load($name);
            if ($module instanceof AdminDashboardItem && $this->access->isGranted($module->id)) {
                $modules[$module->adminGroup()][$module->adminName()] = $module;
            }
        }

        ksort($modules);

        return $modules;
    }
}
