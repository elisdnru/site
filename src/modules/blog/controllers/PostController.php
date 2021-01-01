<?php

namespace app\modules\blog\controllers;

use app\components\module\admin\AdminAccess;
use app\modules\blog\models\Post;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class PostController extends Controller
{
    /**
     * @param int $id
     * @param Request $request
     * @param AdminAccess $access
     * @param string|null $alias
     * @return string|Response
     */
    public function actionShow(int $id, Request $request, AdminAccess $access, ?string $alias = null)
    {
        $model = $this->loadModel($id, $access);

        if ('/' . $request->getPathInfo() !== $model->getUrl()) {
            return $this->redirect(Url::current(['alias' => $model->alias]), 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    private function loadModel(int $id, AdminAccess $access): Post
    {
        $query = Post::find();

        if (!$access->isGranted('blog')) {
            $query = $query->published();
        }

        $model = $query->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
