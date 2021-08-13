<?php

declare(strict_types=1);

namespace app\components\module\admin;

use app\components\module\Modules;

final class AdminNotifications
{
    private Modules $modules;

    public function __construct(Modules $modules)
    {
        $this->modules = $modules;
    }

    /**
     * @return array[]
     * @psalm-return array<array-key, array{label: string, url: string|array}>
     */
    public function notifications(string $module): array
    {
        $class = ModuleClass::getClass($this->modules->definitions(), $module);

        if (!is_subclass_of($class, AdminNotificationsProvider::class)) {
            return [];
        }

        /** @var AdminNotificationsProvider $class */
        return $class::adminNotifications();
    }
}
