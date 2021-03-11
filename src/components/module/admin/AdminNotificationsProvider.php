<?php

namespace app\components\module\admin;

interface AdminNotificationsProvider extends AdminDashboardItem
{
    /**
     * @return array[]
     * @psalm-return array<array-key, array{label: string, url: string|array}>
     */
    public static function adminNotifications(): array;
}
