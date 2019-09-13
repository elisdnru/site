<?php

namespace app\modules\main\controllers;

use CHttpException;
use app\modules\main\components\DController;
use Page;
use Yii;

class ErrorController extends DController
{
    public function actionIndex()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('index', [
                    'error' => $error,
                    'page' => $this->loadPage()
                ]);
                Yii::app()->end();
            }
        } else {
            throw new CHttpException(404, 'Страница не найдена');
        }
    }

    protected function loadPage()
    {
        if (!$page = Page::model()->findByAlias('error')) {
            $page = new Page();
        }
        return $page;
    }
}
