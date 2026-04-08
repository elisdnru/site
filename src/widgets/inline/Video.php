<?php

declare(strict_types=1);

namespace app\widgets\inline;

use Override;
use yii\base\Widget;

final class Video extends Widget
{
    public string $src = '';

    #[Override]
    public function run(): string
    {
        return $this->render('Video', [
            'src' => $this->src,
        ]);
    }
}
