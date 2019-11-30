<?php

namespace app\components;

use InvalidArgumentException;

class DateFormatter
{
    public static function format($date, bool $showTime = false, bool $showMonth = true): string
    {
        if (is_numeric($date)) {
            $time = $date;
        } elseif (!$time = strtotime($date)) {
            throw new InvalidArgumentException('Invalid Date');
        }

        $months = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

        if ($showMonth) {
            $resultDate = (int)date('d', $time) . ' ' . $months[(int)date('m', $time)] . ' ' . date('Y', $time);
        } else {
            $resultDate = date('d', $time) . '-' . date('m', $time) . '-' . date('Y', $time);
        }

        if ($showTime) {
            $resultDate .= ' ' . date('H', $time) . ':' . date('i', $time);
        }

        return $resultDate;
    }
}
