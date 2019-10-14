<?php

namespace app\modules\contact\controllers;

use app\components\Controller;

class DefaultController extends Controller
{
    public function actions(): array
    {
        return [
            'captcha' => [
                'class' => \app\components\actions\CaptchaAction::class,
            ],
        ];
    }
}
