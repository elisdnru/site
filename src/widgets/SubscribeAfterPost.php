<?php

declare(strict_types=1);

namespace app\widgets;

use yii\base\Widget;

final class SubscribeAfterPost extends Widget
{
    public function run(): string
    {
        return $this->render('SubscribeAfterPost');
    }
}
