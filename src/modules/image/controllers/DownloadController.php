<?php

namespace app\modules\image\controllers;

use app\components\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DownloadController extends Controller
{
    public function actionThumb(): Response
    {
        $file = trim(Yii::$app->request->getPathInfo(), '/');

        if (!Yii::$app->uploader->checkThumbExists($file)) {
            throw new NotFoundHttpException('Not found');
        }

        return $this->redirect('/' . $file);
    }
}
