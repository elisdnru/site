<?php

namespace app\modules\contact\controllers;

use app\components\Controller;
use yii\captcha\CaptchaAction;

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
