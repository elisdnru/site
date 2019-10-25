<?php

namespace app\modules\landing\controllers;

use CHttpException;
use app\components\Controller;
use app\modules\landing\models\Landing;
use app\extensions\cachetagging\Tags;

class LandingController extends Controller
{
    public function actionShow($path = 'index'): void
    {
        $landing = $this->loadModel($path);

        $this->layout = false;

        $this->render('show', [
            'landing' => $landing,
        ]);
    }

    protected function loadModel($path): Landing
    {
        $landing = Landing::model()->cache(0, new Tags('landing'))->findByPath($path);
        if ($landing === null) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $landing;
    }
}
