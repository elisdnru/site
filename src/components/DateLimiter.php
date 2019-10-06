<?php

namespace app\components;

use CComponent;

/**
 *
 * @property string $year
 * @property string $month
 * @property string $day
 * @property string $searchString
 * @property string $date
 */
class DateLimiter extends CComponent
{
    protected $year = 0;
    protected $month = 0;
    protected $day = 0;

    /**
     * @param string $date
     */
    public function __construct($date = '')
    {
        $this->date = $date;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if ($this->month > 12 || $this->day > 31) {
            return false;
        }

        if (($this->year && $this->month) || ($this->year && !$this->day)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getSearchString()
    {
        return $this->getDate() . '%';
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        if (preg_match('/(\d{4})-?(\d{2})?-?(\d{2})?/', $date, $m)) {
            $this->year = isset($m[1]) ? (int)$m[1] : 0;
            $this->month = isset($m[2]) ? (int)$m[2] : 0;
            $this->day = isset($m[3]) ? (int)$m[3] : 0;
        }
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->nulled($this->year, 4) . ($this->month ? '-' . $this->nulled($this->month, 2) : '') . ($this->day ? '-' . $this->nulled($this->day, 2) : '');
    }

    public function setDay($day)
    {
        $day = (int)$day;
        $this->day = 0 < $day && $day < 32 ? $day : 0;
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int $month
     */
    public function setMonth($month)
    {
        $month = (int)$month;
        $this->month = 0 < $month && $month < 13 ? $month : 0;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $year = (int)$year;
        $this->year = 0 < $year ? $year : 0;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    protected function nulled($val, $length)
    {
        return str_pad($val, $length, 0, STR_PAD_LEFT);
    }
}
