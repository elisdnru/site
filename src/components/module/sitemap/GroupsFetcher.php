<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use RuntimeException;
use yii\base\Application;

class GroupsFetcher
{
    private Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        /** @var Set[] $sets */
        $sets = [];

        /**
         * @var string $name
         * @var array $definition
         */
        foreach ($this->app->getModules() as $name => $definition) {
            if (($set = $this->getGroupsSet($name, $definition)) !== null) {
                $sets[] = $set;
            }
        }

        usort($sets, static function (Set $a, Set $b) {
            return $b->priority <=> $a->priority;
        });

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
        if (is_object($module)) {
            $class = get_class($module);
        } else {
            /**
             * @var SitemapProvider|null $class
             * @psalm-var class-string|null $class
             */
            $class = $module['class'] ?? null;
        }

        if ($class === null) {
            throw new RuntimeException('Undefined class for module ' . $name);
        }

        if (!is_subclass_of($class, SitemapProvider::class)) {
            return null;
        }

        return new Set(
            $class::sitemap(),
            $class::sitemapPriority()
        );
    }
}
