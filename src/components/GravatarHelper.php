<?php

namespace app\components;

class GravatarHelper
{
    const DEFAULT_GRAVATAR = '';
    const DEFAULT_404 = '404';
    const DEFAULT_MYSTERYMAN = 'mm';
    const DEFAULT_ABSTRACT = 'identicon';
    const DEFAULT_FACE = 'wavatar';
    const DEFAULT_MONSTER = 'monsterid';
    const DEFAULT_RETRO = 'retro';
    const DEFAULT_BLANK = 'blank';

    public static function get(?string $email, int $width = 0, string $default = self::DEFAULT_GRAVATAR): string
    {
        $id = md5(strtolower(trim($email)));
        $default = '?d=' . urlencode($default);
        return '//www.gravatar.com/avatar/' . $id . $default . ($width ? '&s=' . $width : '');
    }
}
