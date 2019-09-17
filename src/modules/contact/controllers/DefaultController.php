<?php

namespace app\modules\contact\controllers;

use app\modules\main\components\Controller;

class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => \app\modules\main\components\actions\CaptchaAction::class,
            ],
        ];
    }
}
