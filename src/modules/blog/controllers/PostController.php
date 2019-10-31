<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Post;
use app\components\Controller;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    public function actionShow($id)
    {
        $model = $this->loadModel($id);

        if ('/' . Yii::$app->request->getPathInfo() !== $model->getUrl()) {
            return $this->redirect(Url::current(['alias' => $model->alias]), 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    protected function loadModel($id): Post
    {
        if (Yii::$app->moduleManager->allowed('blog')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = Post::model()->findByPk($id, $condition);
        if ($model === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $model;
    }
}
