<?php

declare(strict_types=1);

namespace app\widgets\inline;

use yii\base\Widget;

class CountDownWidget extends Widget
{
    public $title;
    public $date;

    public function run(): string
    {
        return $this->render('CountDown', [
            'title' => $this->title,
            'date' => $this->date,
        ]);
    }
}
