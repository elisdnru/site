<?php

declare(strict_types=1);

namespace app\widgets;

use Override;
use yii\base\Widget;

final class SubscribeAfterPost extends Widget
{
    #[Override]
    public function run(): string
    {
        return $this->render('SubscribeAfterPost');
    }
}
