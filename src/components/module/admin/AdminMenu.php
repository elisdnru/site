<?php

declare(strict_types=1);

namespace app\components\module\admin;

use app\components\module\Modules;

final readonly class AdminMenu
{
    private Modules $modules;

    /**
     * @psalm-api
     */
    public function __construct(Modules $modules)
    {
        $this->modules = $modules;
    }

    public function menu(string $module): array
    {
        $class = ModuleClass::getClass($this->modules->definitions(), $module);

        if (!is_subclass_of($class, AdminMenuProvider::class)) {
            return [];
        }

        /** @var AdminMenuProvider $class */
        return $class::adminMenu();
    }
}
