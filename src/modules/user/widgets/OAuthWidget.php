<?php

declare(strict_types=1);

namespace app\modules\user\widgets;

use Override;
use yii\base\Widget;

final class OAuthWidget extends Widget
{
    public string $display = '';
    public string $return = '';

    #[Override]
    public function run(): string
    {
        return $this->render('OAuth', [
            'display' => $this->display,
            'return' => $this->return,
        ]);
    }
}
