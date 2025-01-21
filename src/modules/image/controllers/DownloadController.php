<?php

declare(strict_types=1);

namespace app\modules\image\controllers;

use app\components\uploader\Uploader;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

/**
 * @psalm-api
 */
final class DownloadController extends Controller
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
