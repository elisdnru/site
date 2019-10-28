<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Post;
use CHttpException;
use app\components\Controller;
use Yii;
use yii\helpers\Url;

class PostController extends Controller
{
    public function actionShow($id): string
    {
        $model = $this->loadModel($id);

        if ('/' . Yii::$app->request->getPathInfo() !== $model->getUrl()) {
            $this->redirect(Url::current(['alias' => $model->alias]), true, 301);
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
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }
}
