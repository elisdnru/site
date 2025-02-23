<?php

declare(strict_types=1);

namespace app\widgets;

use Override;
use yii\base\Widget;

final class Follow extends Widget
{
    #[Override]
    public function run(): string
    {
        return $this->render('Follow');
    }
}
