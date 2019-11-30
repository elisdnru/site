<?php

namespace app\components;

use yii\captcha\CaptchaAction;

class MathCaptchaAction extends CaptchaAction
{
    protected function generateVerifyCode()
    {
        return random_int(3, 20);
    }

    protected function renderImage($code): string
    {
        return parent::renderImage($this->getText($code));
    }

    protected function getText($code): string
    {
        $code = (int)$code;
        $rand = random_int(min(1, $code - 1), max(1, $code - 1));
        if (random_int(0, 1) === 1) {
            return $code - $rand . '+' . $rand;
        }
        return $code + $rand . '-' . $rand;
    }
}
