<?php

declare(strict_types=1);

namespace app\components;

final class Gravatar
{
    public static function url(?string $email, int $width): string
    {
        $id = md5(strtolower(trim($email ?: '')));
        return 'https://www.gravatar.com/avatar/' . $id . '?d=identicon' . ($width ? '&s=' . $width : '');
    }
}
