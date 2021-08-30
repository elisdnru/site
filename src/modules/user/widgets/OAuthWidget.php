<?php

declare(strict_types=1);

namespace app\modules\user\widgets;

use yii\base\Widget;

final class OAuthWidget extends Widget
{
    public string $display = '';
    public string $return = '';

    public function run(): string
    {
        return $this->render('OAuth', [
            'display' => $this->display,
            'return' => $this->return,
        ]);
    }
}
