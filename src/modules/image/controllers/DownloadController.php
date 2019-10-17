<?php

namespace app\modules\image\controllers;

use CHttpException;
use app\components\Controller;
use Yii;

class DownloadController extends Controller
{
    public function actionThumb(): void
    {
        $file = trim(Yii::app()->request->requestUri, '/');

        if (!Yii::$app->uploader->checkThumbExists($file)) {
            throw new CHttpException(404, 'Not found');
        }

        $this->redirect('/' . $file);
    }
}
