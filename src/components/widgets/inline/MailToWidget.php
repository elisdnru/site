<?php

declare(strict_types=1);

namespace app\components\widgets\inline;

use yii\base\Widget;

class MailToWidget extends Widget
{
    public $email;
    public $date;

    public function run(): string
    {
        return $this->render('MailTo', [
            'email' => $this->email,
        ]);
    }
}