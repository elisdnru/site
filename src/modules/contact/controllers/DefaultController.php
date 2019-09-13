<?php

namespace app\modules\contact\controllers;

use app\modules\main\components\DController;

class DefaultController extends DController
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => \app\modules\main\components\actions\DCaptchaAction::class,
            ],
        ];
    }
}
