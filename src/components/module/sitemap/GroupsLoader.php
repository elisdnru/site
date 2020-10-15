<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use RuntimeException;
use yii\base\Application;

class GroupsLoader
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
        $groups = [];

        /**
         * @var string $name
         * @var array $definition
         * @psalm-var array{class: ?string} $definition
         */
        foreach ($this->app->getModules() as $name => $definition) {
            foreach ($this->getGroupsSet($name, $definition) as $group) {
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

    /**
     * @param string $name
     * @param array|object $module
     * @return Group[]
     */
    private function getGroupsSet(string $name, $module): array
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
            return [];
        }

        return $class::sitemap();
    }
}
