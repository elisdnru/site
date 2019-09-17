<?php

namespace app\modules\uploader\controllers;

use CHttpException;
use app\modules\main\components\Controller;
use Yii;

class DownloadController extends Controller
{
    public function actionThumb()
    {
        $file = trim(Yii::app()->request->requestUri, '/');

        if (!$thumb = Yii::app()->uploader->checkThumbExists($file)) {
            throw new CHttpException(404, 'Not found');
        }

        $this->redirect('/' . $file);
    }
}
