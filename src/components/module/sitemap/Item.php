<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class Item
{
    public string $url;
    public ?string $label;
    public ?Xml $xml;
    /**
     * @var Item[]
     */
    public array $children;

    /**
     * Item constructor.
     * @param Item[] $children
     */
    public function __construct(string $url, ?string $label, ?Xml $xml, array $children)
    {
        Assert::notEmpty($url);

        $this->label = $label;
        $this->url = $url;
        $this->xml = $xml;
        $this->children = $children;
    }
}
