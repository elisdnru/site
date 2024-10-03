<?php

declare(strict_types=1);

namespace app\widgets\inline;

use yii\base\Widget;

final class RuTube extends Widget
{
    public string $id = '';

    public function run(): string
    {
        return $this->render('RuTube', [
            'id' => $this->id,
        ]);
    }
}
