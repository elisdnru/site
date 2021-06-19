<?php

declare(strict_types=1);

namespace app\components\module\admin;

interface AdminMenuProvider extends AdminDashboardItem
{
    public static function adminMenu(): array;
}
