<?php

namespace app\modules\image\controllers;

use yii\web\Controller;
use app\components\uploader\Uploader;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class DownloadController extends Controller
{
    public function actionThumb(Request $request, Uploader $uploader): Response
    {
        $file = trim($request->getPathInfo(), '/');

        if (!$uploader->checkThumbExists($file)) {
            throw new NotFoundHttpException();
        }

        return $this->redirect('/' . $file);
    }
}
