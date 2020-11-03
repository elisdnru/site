<?php

namespace app\components\module\admin;

interface AdminMenuProvider extends AdminDashboardItem
{
    public static function adminMenu(): array;
}
