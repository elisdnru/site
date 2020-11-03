<?php

namespace app\components\module\admin;

interface AdminNotificationsProvider extends AdminDashboardItem
{
    /**
     * @return array[]
     */
    public static function adminNotifications(): array;
}
