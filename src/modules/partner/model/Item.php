<?php

declare(strict_types=1);

namespace app\modules\partner\model;

final readonly class Item
{
    public string $title;
    public string $url;
    public int $price;
    public int $firstPercent;

    public function __construct(
        string $title,
        string $url,
        int $price,
        int $firstPercent,
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->price = $price;
        $this->firstPercent = $firstPercent;
    }

    public function firstRoubles(): float
    {
        return $this->price * $this->firstPercent / 100;
    }
}
