<?php

declare(strict_types=1);

namespace app\modules\search\models;

/**
 * @psalm-immutable
 */
class Image
{
    public int $width;
    public int $height;
    public string $thumbUrl;

    public function __construct(int $width, int $height, string $thumbUrl)
    {
        $this->width = $width;
        $this->height = $height;
        $this->thumbUrl = $thumbUrl;
    }
}
