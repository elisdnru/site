<?php

declare(strict_types=1);

namespace app\modules\block\controllers\admin;

use app\components\AdminController;
use app\modules\block\forms\BlockSearch;
use app\modules\block\models\Block;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class BlockController extends AdminController
{
    public function actionIndex(Request $request): string
    {
        $model = new BlockSearch();
        $dataProvider = $model->search($request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new Block();
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

    public function actionView(int $id): string
    {
        $model = $this->loadModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function loadModel(int $id): Block
    {
        $model = Block::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
