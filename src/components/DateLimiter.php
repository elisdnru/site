<?php

namespace app\components;

class DateLimiter
{
    private int $year = 0;
    private int $month = 0;
    private int $day = 0;

    public function __construct(string $date)
    {
        if (preg_match('/(\d{4})-?(\d{2})?-?(\d{2})?/', $date, $m)) {
            $this->year = isset($m[1]) ? (int)$m[1] : 0;
            $this->month = isset($m[2]) ? (int)$m[2] : 0;
            $this->day = isset($m[3]) ? (int)$m[3] : 0;
        }
    }

    public function isValid(): bool
    {
        if ($this->month > 12) {
            return false;
        }

        if ($this->day > 31) {
            return false;
        }

        if ($this->year && $this->month) {
            return true;
        }

        if ($this->year && !$this->day) {
            return true;
        }

        return false;
    }

    public function getDate(): string
    {
        return $this->pad($this->year, 4) . ($this->month ? '-' . $this->pad($this->month, 2) : '') . ($this->day ? '-' . $this->pad($this->day, 2) : '');
    }

    private function pad(int $val, int $length): string
    {
        return str_pad($val, $length, 0, STR_PAD_LEFT);
    }
}
