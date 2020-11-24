<?php

declare(strict_types=1);

namespace app\components\module\admin;

use InvalidArgumentException;

class ModuleClass
{
    /**
     * @param mixed[] $modules
     * @param string $name
     * @return string
     */
    public static function getClass(array $modules, string $name): string
    {
        $module = $modules[$name] ?? null;

        if ($module !== null && is_object($module)) {
            return get_class($module);
        }
        if ($module !== null && is_array($module)) {
            return $module['class'];
        }

        throw new InvalidArgumentException('Cannot detect module class ' . $name);
    }
}
