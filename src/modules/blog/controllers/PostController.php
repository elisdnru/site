<?php

declare(strict_types=1);

namespace app\modules\blog\controllers;

use app\components\module\admin\AdminAccess;
use app\modules\blog\models\Post;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

/**
 * @psalm-api
 */
final class PostController extends Controller
{
    public function actionShow(int $id, Request $request, AdminAccess $access, ?string $slug = null): Response|string
    {
        $model = $this->loadModel($id, $access);

        $path = Url::to(['/blog/post/show', 'id' => $model->id, 'slug' => $model->slug]);

        if ('/' . $request->getPathInfo() !== $path) {
            return $this->redirect(Url::current(['slug' => $model->slug]), 301);
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

        if (!$model instanceof Post) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
