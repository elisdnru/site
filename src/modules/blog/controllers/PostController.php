<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Post;
use app\components\Controller;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class PostController extends Controller
{
    public function actionShow(int $id, ?string $alias = null, Request $request)
    {
        $model = $this->loadModel($id);

        if ('/' . $request->getPathInfo() !== $model->getUrl()) {
            return $this->redirect(Url::current(['alias' => $model->alias]), 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    private function loadModel(int $id): Post
    {
        $query = Post::find();

        if (!Yii::$app->moduleAdminAccess->isGranted('blog')) {
            $query = $query->published();
        }

        $model = $query->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
