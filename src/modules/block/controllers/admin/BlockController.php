<?php

namespace app\modules\block\controllers\admin;

use app\modules\block\models\Block;
use app\modules\block\forms\BlockSearch;
use CHttpException;
use app\components\AdminController;
use Yii;

class BlockController extends AdminController
{
    public function actionIndex(): void
    {
        $model = new BlockSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Block();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        }
        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id): void
    {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        }
        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id): void
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(['index']);
        }
    }

    public function actionView($id): void
    {
        $model = $this->loadModel($id);
        $this->render('view', [
            'model' => $model,
        ]);
    }

    public function loadModel($id): Block
    {
        $model = Block::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
