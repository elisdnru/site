<?php

declare(strict_types=1);

namespace app\components;

final class Pluraliser
{
    /**
     * @param string[] $input array('товар', 'товара', 'товаров')
     */
    public static function plural(int $amount, array $input): string
    {
        $l2 = substr((string)$amount, -2);
        $l1 = substr((string)$amount, -1);

        if ((int)$l2 > 10 && (int)$l2 < 20) {
            return $input[2];
        }

        return match ($l1) {
            '1' => $input[0],
            '2', '3', '4' => $input[1],
            default => $input[2],
        };
    }
}
