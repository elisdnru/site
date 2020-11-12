<?php

declare(strict_types=1);

namespace app\components\module\admin;

use Yii;

class AdminDashboard
{
    private AdminAccess $access;

    public function __construct(AdminAccess $access)
    {
        $this->access = $access;
    }

    public function groupedModules(): array
    {
        $modules = [];

        foreach (Yii::$app->getModules() as $key => $value) {
            $module = Yii::$app->getModule($key);
            if ($module && $module instanceof AdminDashboardItem && $this->access->isGranted($module->id)) {
                $modules[$module->adminGroup()][$module->adminName()] = $module;
            }
        }

        ksort($modules);

        return $modules;
    }
}
