<?php

declare(strict_types=1);

namespace app\components\module\routes;

/**
 * @psalm-immutable
 */
class Group
{
    public array $rules;
    public int $priority;

    public function __construct(array $rules, int $priority)
    {
        $this->rules = $rules;
        $this->priority = $priority;
    }
}
