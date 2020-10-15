<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

/**
 * @psalm-immutable
 */
class Set
{
    /**
     * @var Group[]
     */
    public array $groups;
    public int $priority;

    /**
     * @param Group[] $groups
     * @param int $priority
     */
    public function __construct(array $groups, int $priority)
    {
        $this->groups = $groups;
        $this->priority = $priority;
    }
}
