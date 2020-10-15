<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
class Item
{
    public const ALWAYS = 'always';
    public const HOURLY = 'hourly';
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';
    public const YEARLY = 'yearly';
    public const NEVER = 'never';

    public string $url;
    public string $label;
    public string $changeFreq;
    public float $priority;
    public ?DateTimeImmutable $lastMod = null;
    /**
     * @var Item[]
     */
    public array $children;

    /**
     * Item constructor.
     * @param string $url
     * @param string $label
     * @param string $changeFreq
     * @param float $priority
     * @param DateTimeImmutable|null $lastMod
     * @param Item[] $children
     */
    public function __construct(
        string $url,
        string $label,
        string $changeFreq,
        float $priority,
        ?DateTimeImmutable $lastMod,
        array $children
    ) {
        Assert::notEmpty($url);

        Assert::inArray($changeFreq, [
            self::ALWAYS,
            self::HOURLY,
            self::DAILY,
            self::WEEKLY,
            self::MONTHLY,
            self::YEARLY,
            self::NEVER,
        ]);

        $this->label = $label;
        $this->url = $url;
        $this->changeFreq = $changeFreq;
        $this->priority = $priority;
        $this->lastMod = $lastMod;
        $this->children = $children;
    }
}
