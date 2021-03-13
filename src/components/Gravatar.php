<?php

namespace app\components;

class Gravatar
{
    public const DEFAULT_GRAVATAR = '';
    public const DEFAULT_404 = '404';
    public const DEFAULT_MYSTERYMAN = 'mm';
    public const DEFAULT_ABSTRACT = 'identicon';
    public const DEFAULT_FACE = 'wavatar';
    public const DEFAULT_MONSTER = 'monsterid';
    public const DEFAULT_RETRO = 'retro';
    public const DEFAULT_BLANK = 'blank';

    public static function url(?string $email, int $width = 0, string $default = self::DEFAULT_ABSTRACT): string
    {
        $id = md5(strtolower(trim($email ?: '')));
        $default = '?d=' . urlencode($default);
        return 'https://www.gravatar.com/avatar/' . $id . $default . ($width ? '&s=' . $width : '');
    }
}
