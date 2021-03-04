<?php

namespace app\components\module\admin;

use app\components\module\Modules;

class AdminMenu
{
    private Modules $modules;

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
