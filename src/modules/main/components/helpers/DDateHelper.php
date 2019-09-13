<?php


class DDateHelper
{
    public static function normdate($date, $showTime = false, $showMonth = true)
    {

        if (is_numeric($date)) {
            $time = $date;
        } elseif (!$time = strtotime($date)) {
            throw new CException('Invalid Date');
        }

        $months = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

        if ($showMonth) {
            $resultDate = intval(date('d', $time)) . ' ' . $months[intval(date('m', $time))] . ' ' . date('Y', $time);
        } else {
            $resultDate = date('d', $time) . '-' . date('m', $time) . '-' . date('Y', $time);
        }

        if ($showTime) {
            $resultDate .= ' ' . date('H', $time) . ':' . date('i', $time);
        }

        return $resultDate;
    }
}
