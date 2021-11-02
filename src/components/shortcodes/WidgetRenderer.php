<?php

declare(strict_types=1);

namespace app\components\shortcodes;

use yii\base\Widget;

final class WidgetRenderer
{
    public function render(string $class, array $attributes): string
    {
        ob_start();
        /** @var class-string<Widget> $class */
        echo $class::widget($attributes);
        return trim(ob_get_clean());
    }
}
