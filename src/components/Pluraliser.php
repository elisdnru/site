<?php

declare(strict_types=1);

namespace app\components;

final class Pluraliser
{
    /**
     * Множественное число
     * https://github.com/mbakirov/UHelpers/.
     * @param string[] $input array('товар', 'товара', 'товаров')
     */
    public static function plural(int $amount, array $input): string
    {
        $l2 = substr((string)$amount, -2);
        $l1 = substr((string)$amount, -1);

        if ($l2 > 10 && $l2 < 20) {
            return $input[2];
        }

        switch ($l1) {
            case 1:
                return $input[0];
            case 2:
            case 3:
            case 4:
                return $input[1];
            case 0:
            default:
                return $input[2];
        }
    }
}
