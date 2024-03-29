<?php

declare(strict_types=1);

namespace app\components;

use InvalidArgumentException;

final class DateFormatter
{
    public static function format(int|string $date, bool $showTime = false, bool $showMonth = true): string
    {
        /** @var int $time */
        if (\is_int($date)) {
            $time = $date;
        }

        if (\is_string($date)) {
            $time = strtotime($date);
            if (!$time) {
                throw new InvalidArgumentException('Invalid Date');
            }
        }

        $months = [
            '', 'января', 'февраля', 'марта',
            'апреля', 'мая', 'июня',
            'июля', 'августа', 'сентября',
            'октября', 'ноября', 'декабря',
        ];

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
