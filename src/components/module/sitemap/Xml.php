<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

final readonly class Xml
{
    public const string ALWAYS = 'always';
    public const string HOURLY = 'hourly';
    public const string DAILY = 'daily';
    public const string WEEKLY = 'weekly';
    public const string MONTHLY = 'monthly';
    public const string YEARLY = 'yearly';
    public const string NEVER = 'never';

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
