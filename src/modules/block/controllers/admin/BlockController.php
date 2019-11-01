<?php

namespace app\modules\block\controllers\admin;

use app\modules\block\models\Block;
use app\modules\block\forms\BlockSearch;
use app\components\AdminController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BlockController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new BlockSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Block();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView($id): string
    {
        $model = $this->loadModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function loadModel($id): Block
    {
        $model = Block::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
