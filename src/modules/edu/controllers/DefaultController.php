<?php

namespace app\modules\edu\controllers;

use app\components\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
