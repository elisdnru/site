<?php

namespace app\components\helpers;

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

    public static function get($email, $width = 0, $default = self::DEFAULT_GRAVATAR)
    {
        $id = md5(strtolower(trim($email)));
        $default = '?d=' . urlencode($default);
        $width = $width ? '&s=' . $width : '';
        return '//www.gravatar.com/avatar/' . $id . $default . $width;
    }
}
