<?php

declare(strict_types=1);

namespace app\components;

class FilenameGenerator
{
    public static function generate(string $path, string $extension = ''): string
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . random_int(0, 9999));
            $file = $path . $name . $extension;
            usleep(1);
        } while (file_exists($file));

        return $name;
    }
}
