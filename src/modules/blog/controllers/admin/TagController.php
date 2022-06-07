<?php

declare(strict_types=1);

namespace app\modules\blog\controllers\admin;

use app\components\AdminController;
use app\modules\blog\forms\admin\TagSearch;
use app\modules\blog\models\Tag;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class TagController extends AdminController
{
    public function actionIndex(Request $request): string
    {
        $model = new TagSearch();
        $dataProvider = $model->search($request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new Tag();

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

    public function actionDelete(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(): Response
    {
        return $this->redirect(['index']);
    }

    private function loadModel(int $id): Tag
    {
        $model = Tag::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
