<?php

namespace app\components;

use Yii;

class NumberHelper
{
    /**
     * Множественное число
     * https://github.com/mbakirov/UHelpers/
     * @param int $howmuch
     * @param array $input array('товар', 'товара', 'товаров')
     * @return string
     */
    public static function plural(int $howmuch, array $input): string
    {
        $l2 = substr($howmuch, -2);
        $l1 = substr($howmuch, -1);

        if ($l2 > 10 && $l2 < 20) {
            return $input[2];
        }

        switch ($l1) {
            case 0:
                return $input[2];
                break;
            case 1:
                return $input[0];
                break;
            case 2:
            case 3:
            case 4:
                return $input[1];
                break;
            default:
                return $input[2];
                break;
        }
    }

    public static function pageString(string $param = 'page'): string
    {
        $page = (int)Yii::$app->request->get($param, 1);
        return $page > 1 ? ' - Страница ' . $page : '';
    }
}
