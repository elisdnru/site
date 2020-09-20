<?php

namespace app\modules\home\controllers;

use app\components\Controller;
use yii\web\ErrorAction;

class ErrorController extends Controller
{
    public function actions(): array
    {
        return [
            'index' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
