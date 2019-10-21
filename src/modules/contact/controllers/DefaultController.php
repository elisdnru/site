<?php

namespace app\modules\contact\controllers;

use app\components\actions\CaptchaAction;
use app\components\Controller;

class DefaultController extends Controller
{
    public function actions(): array
    {
        return [
            'captcha' => [
                'class' => CaptchaAction::class,
            ],
        ];
    }
}
