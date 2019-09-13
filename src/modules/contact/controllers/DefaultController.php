<?php

namespace app\modules\contact\controllers;

use DController;

class DefaultController extends DController
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => \DCaptchaAction::class,
            ],
        ];
    }
}
