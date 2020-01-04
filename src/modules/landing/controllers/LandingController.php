<?php

namespace app\modules\landing\controllers;

use app\components\Controller;
use app\modules\landing\models\Landing;
use app\extensions\cachetagging\Tags;
use yii\web\NotFoundHttpException;

class LandingController extends Controller
{
    public function actionShow(string $path = 'index'): string
    {
        $landing = $this->loadModel($path);

        $this->layout = false;

        return $this->render('show', [
            'landing' => $landing,
        ]);
    }

    private function loadModel(string $path): Landing
    {
        /** @var Landing $landing */
        $landing = Landing::model()->cache(0, new Tags('landing'))->findByPath($path);
        if ($landing === null) {
            throw new NotFoundHttpException();
        }
        return $landing;
    }
}
