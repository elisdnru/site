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

    public function __construct(string $date = '')
    {
        $this->date = $date;
    }

    public function validate(): bool
    {
        if ($this->month > 12 || $this->day > 31) {
            return false;
        }

        if (($this->year && $this->month) || ($this->year && !$this->day)) {
            return true;
        }

        return false;
    }

    public function getSearchString(): string
    {
        return $this->getDate() . '%';
    }

    public function setDate(string $date): void
    {
        if (preg_match('/(\d{4})-?(\d{2})?-?(\d{2})?/', $date, $m)) {
            $this->year = isset($m[1]) ? (int)$m[1] : 0;
            $this->month = isset($m[2]) ? (int)$m[2] : 0;
            $this->day = isset($m[3]) ? (int)$m[3] : 0;
        }
    }

    public function getDate(): string
    {
        return $this->nulled($this->year, 4) . ($this->month ? '-' . $this->nulled($this->month, 2) : '') . ($this->day ? '-' . $this->nulled($this->day, 2) : '');
    }

    public function setDay(int $day): void
    {
        $this->day = 0 < $day && $day < 32 ? $day : 0;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function setMonth(int $month): void
    {
        $this->month = 0 < $month && $month < 13 ? $month : 0;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setYear(int $year): void
    {
        $this->year = 0 < $year ? $year : 0;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    protected function nulled(int $val, int $length): string
    {
        return str_pad($val, $length, 0, STR_PAD_LEFT);
    }
}
