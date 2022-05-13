<?php

declare(strict_types=1);

namespace app\components;

final class FilenameEscaper
{
    public static function escapeFile(string $name): string
    {
        $result = self::escapePath($name);
        return preg_replace('#/+#', '_', $result);
    }

    public static function escapePath(string $name): string
    {
        $result = Transliterator::translit($name);
        $result = preg_replace('#[^\w/.-]#i', '_', $result);
        $result = preg_replace('#_+#i', '_', $result);
        $result = preg_replace('#\.+#i', '.', $result);
        $result = preg_replace('#^[./]+#i', '', $result);
        return preg_replace('#[./]+$#i', '', $result);
    }
}
