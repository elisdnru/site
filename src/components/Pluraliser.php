<?php

namespace app\components;

class Pluraliser
{
    /**
     * Множественное число
     * https://github.com/mbakirov/UHelpers/
     * @param int $amount
     * @param array $input array('товар', 'товара', 'товаров')
     * @return string
     */
    public static function plural(int $amount, array $input): string
    {
        $l2 = substr($amount, -2);
        $l1 = substr($amount, -1);

        if ($l2 > 10 && $l2 < 20) {
            return $input[2];
        }

        switch ($l1) {
            case 1:
                return $input[0];
                break;
            case 2:
            case 3:
            case 4:
                return $input[1];
                break;
            case 0:
            default:
                return $input[2];
                break;
        }
    }
}