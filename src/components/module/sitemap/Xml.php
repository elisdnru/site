<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class Xml
{
    public const ALWAYS = 'always';
    public const HOURLY = 'hourly';
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';
    public const YEARLY = 'yearly';
    public const NEVER = 'never';

    public string $changeFreq;
    public float $priority;
    public ?DateTimeImmutable $lastMod;

    public function __construct(string $changeFreq, float $priority, ?DateTimeImmutable $lastMod)
    {
        Assert::notEmpty($changeFreq);

        Assert::inArray($changeFreq, [
            self::ALWAYS,
            self::HOURLY,
            self::DAILY,
            self::WEEKLY,
            self::MONTHLY,
            self::YEARLY,
            self::NEVER,
        ]);

        $this->changeFreq = $changeFreq;
        $this->priority = $priority;
        $this->lastMod = $lastMod;
    }
}
