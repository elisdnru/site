<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use app\components\module\Modules;
use RuntimeException;

final class GroupsFetcher
{
    private Modules $modules;

    public function __construct(Modules $modules)
    {
        $this->modules = $modules;
    }

    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        /** @var Set[] $sets */
        $sets = [];

        foreach ($this->modules->definitions() as $name => $definition) {
            if (($set = $this->getGroupsSet($name, $definition)) !== null) {
                $sets[] = $set;
            }
        }

        usort($sets, static fn (Set $a, Set $b) => $b->priority <=> $a->priority);

        $groups = [];

        foreach ($sets as $set) {
            foreach ($set->groups as $group) {
                foreach ($group->items as $item) {
                    $groups[$group->name][] = $item;
                }
            }
        }

        $result = [];

        foreach ($groups as $name => $items) {
            $result[$name] = new Group($name, $items);
        }

        return $result;
    }

    private function getGroupsSet(string $name, object|array $module): ?Set
    {
        if (\is_object($module)) {
            $class = $module::class;
        } else {
            /** @psalm-var array{class: class-string<SitemapProvider>|null} $module */
            $class = $module['class'] ?? null;
        }

        if ($class === null) {
            throw new RuntimeException('Undefined class for module ' . $name);
        }

        if (!is_subclass_of($class, SitemapProvider::class)) {
            return null;
        }

        /**
         * @var SitemapProvider $class
         * @psalm-var class-string<SitemapProvider> $class
         */
        return new Set(
            $class::sitemap(),
            $class::sitemapPriority()
        );
    }
}
