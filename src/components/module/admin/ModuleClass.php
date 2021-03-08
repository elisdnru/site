<?php

declare(strict_types=1);

namespace app\components\module\admin;

use RuntimeException;
use yii\base\Module;
use InvalidArgumentException;

class ModuleClass
{
    /**
     * @param array[]|Module[] $modules
     * @psalm-param array<string, array{class?: string}|Module> $modules
     * @param string $name
     * @return string
     */
    public static function getClass(array $modules, string $name): string
    {
        $module = $modules[$name] ?? null;
        if ($module === null) {
            throw new InvalidArgumentException('Cannot detect module ' . $name);
        }
        if (is_object($module)) {
            return get_class($module);
        }
        $class = $module['class'] ?? '';
        if ($class === '') {
            throw new RuntimeException('Undefined class for module ' . $name);
        }
        return $class;
    }
}
