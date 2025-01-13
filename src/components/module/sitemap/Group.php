<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use Webmozart\Assert\Assert;

final readonly class Group
{
    public string $name;
    /**
     * @var Item[]
     */
    public array $items;

    /**
     * @param Item[] $items
     */
    public function __construct(string $name, array $items)
    {
        Assert::notEmpty($name);

        $this->name = $name;
        $this->items = $items;
    }
}
