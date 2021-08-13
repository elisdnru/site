<?php

declare(strict_types=1);

namespace app\widgets\inline;

use yii\base\Widget;

final class YouTube extends Widget
{
    public string $id = '';
    public string $date = '';

    public function run(): string
    {
        return $this->render('YouTube', [
            'id' => $this->id,
        ]);
    }
}
