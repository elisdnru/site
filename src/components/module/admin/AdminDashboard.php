<?php

declare(strict_types=1);

namespace app\components\module\admin;

use Yii;

class AdminDashboard
{
    public function groupedModules(): array
    {
        $modules = [];

        foreach (Yii::$app->modules as $key => $value) {
            $module = Yii::$app->getModule($key);
            if ($module && $module instanceof AdminDashboardItem && Yii::$app->moduleAccess->isGranted($module->id)) {
                $modules[$module->adminGroup()][$module->adminName()] = $module;
            }
        }

        ksort($modules);

        return $modules;
    }
}
