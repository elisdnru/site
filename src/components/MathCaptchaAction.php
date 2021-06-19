<?php

declare(strict_types=1);

namespace app\components;

use yii\captcha\CaptchaAction;

class MathCaptchaAction extends CaptchaAction
{
    protected function generateVerifyCode(): string
    {
        return (string)random_int(3, 20);
    }

    protected function renderImage($code): string
    {
        return parent::renderImage($this->getText($code));
    }

    protected function getText(string $code): string
    {
        $value = (int)$code;
        $rand = random_int(min(1, $value - 1), max(1, $value - 1));
        if (random_int(0, 1) === 1) {
            return $value - $rand . '+' . $rand;
        }
        return $value + $rand . '-' . $rand;
    }
}
