<?php

declare(strict_types=1);

namespace app\modules\portfolio\controllers\admin;

use app\components\AdminController;
use app\modules\portfolio\models\Work;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class WorkController extends AdminController
{
    private const ITEMS_PER_PAGE = 50;

    public function actionIndex(Request $request): string
    {
        $category = (int)$request->get('category');

        $query = Work::find();

        if ($category) {
            $query->category($category);
        }

        $pages = new Pagination([
            'totalCount' => (clone $query)->count(),
            'pageSize' => self::ITEMS_PER_PAGE,
        ]);

        $works = $query
            ->limit($pages->getLimit())
            ->offset($pages->getOffset())
            ->orderBy(['sort' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'works' => $works,
            'category' => $category,
            'pages' => $pages,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new Work();
        $model->public = 1;
        $model->image_show = 1;
        $model->category_id = $request->get('category');
        $model->date = date('Y-m-d H:i:s');

        if ($model->load((array)$request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $model = $this->loadModel($id);
        if ($model->load((array)$request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionToggle(int $id, string $attribute, Request $request): ?Response
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'public') {
            throw new BadRequestHttpException('Missing attribute ' . $attribute);
        }

        $model->{$attribute} = $model->{$attribute} ? '0' : '1';
        $model->save();

        if (!$request->getIsAjax()) {
            return $this->redirect($request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): Response
    {
        $model = $this->loadModel($id);

        return $this->redirect($model->getUrl());
    }

    private function loadModel(int $id): Work
    {
        $model = Work::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
