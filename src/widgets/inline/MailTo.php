<?php

declare(strict_types=1);

namespace app\widgets\inline;

use Override;
use yii\base\Widget;

final class MailTo extends Widget
{
    public string $email = '';

    #[Override]
    public function run(): string
    {
        return $this->render('MailTo', [
            'email' => $this->email,
        ]);
    }
}
