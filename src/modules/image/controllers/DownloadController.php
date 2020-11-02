<?php

namespace app\modules\image\controllers;

use app\components\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class DownloadController extends Controller
{
    public function actionThumb(Request $request): Response
    {
        $file = trim($request->getPathInfo(), '/');

        if (!Yii::$app->uploader->checkThumbExists($file)) {
            throw new NotFoundHttpException();
        }

        return $this->redirect('/' . $file);
    }
}
