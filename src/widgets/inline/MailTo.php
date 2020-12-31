<?php

declare(strict_types=1);

namespace app\widgets\inline;

use yii\base\Widget;

class MailTo extends Widget
{
    public string $email = '';

    public function run(): string
    {
        return $this->render('MailTo', [
            'email' => $this->email,
        ]);
    }
}
