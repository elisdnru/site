<?php

declare(strict_types=1);

namespace app\components\uploader;

final class Parsed
{
    public string $path = '';
    public string $fileName = '';
    public int $width = 0;
    public int $height = 0;
    public string $extension = '';
    public string $baseName = '';
}
