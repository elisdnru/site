<?php

namespace app\modules\home\controllers;

use CHttpException;
use app\components\Controller;
use Yii;

class ErrorController extends Controller
{
    public function actionIndex(): string
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::$app->request->getIsAjax()) {
                return $error['message'];
            }
            return $this->render('index', [
                'error' => $error
            ]);
        }
        throw new CHttpException(404, 'Страница не найдена');
    }
}