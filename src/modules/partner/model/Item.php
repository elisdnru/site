<?php

declare(strict_types=1);

namespace app\modules\partner\model;

final readonly class Item
{
    public string $title;
    public string $url;
    public int $price;
    public int $firstPercent;
    public int $secondPercent;

    public function __construct(
        string $title,
        string $url,
        int $price,
        int $firstPercent,
        int $secondPercent,
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->price = $price;
        $this->firstPercent = $firstPercent;
        $this->secondPercent = $secondPercent;
    }

    public function firstRoubles(): float
    {
        return $this->price * $this->firstPercent / 100;
    }

    public function secondRoubles(): float
    {
        return $this->price * $this->secondPercent / 100;
    }
}
