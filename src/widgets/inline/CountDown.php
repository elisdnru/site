<?php

declare(strict_types=1);

namespace app\widgets\inline;

use yii\base\Widget;

final class CountDown extends Widget
{
    public string $title = '';
    public string $date = '';

    public function run(): string
    {
        return $this->render('CountDown', [
            'title' => $this->title,
            'date' => $this->date,
        ]);
    }
}
