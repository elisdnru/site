<?php

declare(strict_types=1);

namespace app\widgets\inline;

use yii\base\Widget;

final class SubscribeWebinars extends Widget
{
    public function run(): string
    {
        return $this->render('SubscribeWebinars');
    }
}
