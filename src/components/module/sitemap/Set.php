<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

/**
 * @psalm-immutable
 */
final class Set
{
    /**
     * @var Group[]
     */
    public array $groups;
    public int $priority;

    /**
     * @param Group[] $groups
     */
    public function __construct(array $groups, int $priority)
    {
        $this->groups = $groups;
        $this->priority = $priority;
    }
}
