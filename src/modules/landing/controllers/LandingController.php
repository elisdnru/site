<?php

declare(strict_types=1);

namespace app\modules\landing\controllers;

use app\modules\landing\models\Landing;
use yii\caching\TagDependency;
use yii\web\Controller;
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
        /** @var Landing|null $landing */
        $landing = Landing::find()->cache(0, new TagDependency(['tags' => ['landing']]))->findByPath($path);
        if ($landing === null) {
            throw new NotFoundHttpException();
        }
        return $landing;
    }
}
