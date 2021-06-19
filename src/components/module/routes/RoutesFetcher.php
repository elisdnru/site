<?php

declare(strict_types=1);

namespace app\components\module\routes;

use app\components\module\Modules;
use RuntimeException;

class RoutesFetcher
{
    private Modules $modules;

    public function __construct(Modules $modules)
    {
        $this->modules = $modules;
    }

    public function getRules(): array
    {
        $groups = $this->getGroups();

        usort($groups, static fn (Group $a, Group $b) => $b->priority <=> $a->priority);

        return array_merge(
            ...array_map(
                static fn (Group $group) => $group->rules,
                $groups
            )
        );
    }

    /**
     * @return Group[]
     */
    private function getGroups(): array
    {
        /** @var Group[] $groups */
        $groups = [];

        foreach ($this->modules->definitions() as $name => $definition) {
            $class = $definition['class'] ?? '';
            if ($class === '') {
                throw new RuntimeException('Undefined class for module ' . $name);
            }
            if (!is_subclass_of($class, RoutesProvider::class)) {
                continue;
            }
            $groups[] = new Group($class::routes(), $class::routesPriority());
        }

        return $groups;
    }
}
