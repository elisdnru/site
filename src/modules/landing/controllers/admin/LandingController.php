<?php

declare(strict_types=1);

namespace app\modules\landing\controllers\admin;

use app\components\AdminController;
use app\modules\landing\forms\admin\LandingSearch;
use app\modules\landing\models\Landing;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class LandingController extends AdminController
{
    public function actionIndex(Request $request): string
    {
        $model = new LandingSearch();
        $dataProvider = $model->search($request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new Landing();
        $model->parent_id = $request->get('parent');

        if ($model->load((array)$request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $model = $this->loadModel($id);

        if ($model->load((array)$request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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

    private function loadModel(int $id): Landing
    {
        $model = Landing::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
