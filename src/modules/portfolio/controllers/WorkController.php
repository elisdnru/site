<?php

declare(strict_types=1);

namespace app\modules\portfolio\controllers;

use app\components\module\admin\AdminAccess;
use app\modules\portfolio\models\Work;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

/**
 * @psalm-api
 */
final class WorkController extends Controller
{
    public function actionShow(int $id, Request $request, AdminAccess $access, ?string $slug = null): Response|string
    {
        $model = $this->loadModel($id, $access);

        $path = Url::to([
            '/portfolio/work/show',
            'category' => $model->category->getPath(),
            'id' => $model->id,
            'slug' => $model->slug,
        ]);

        if ('/' . $request->getPathInfo() !== $path) {
            return $this->redirect(Url::current([
                'slug' => $model->slug,
                'category' => $model->category->getPath(),
            ]), 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    private function loadModel(int $id, AdminAccess $access): Work
    {
        $query = Work::find();

        if (!$access->isGranted('portfolio')) {
            $query->published();
        }

        /** @var Work|null $model */
        $model = $query->andWhere(['id' => $id])->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
