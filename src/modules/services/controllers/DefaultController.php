<?php

namespace app\modules\services\controllers;

use app\components\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
