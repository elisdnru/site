<?php

declare(strict_types=1);

namespace app\components\module\admin;

interface AdminNotificationsProvider extends AdminDashboardItem
{
    /**
     * @return array[]
     * @psalm-return array<array-key, array{label: string, url: string|array, icon?: string}>
     */
    public static function adminNotifications(): array;
}
