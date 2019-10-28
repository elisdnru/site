<?php

namespace app\modules\landing\controllers\admin;

use CHttpException;
use app\components\AdminController;
use app\modules\landing\models\Landing;
use Yii;

class LandingController extends AdminController
{
    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + deleteFile',
        ]);
    }

    public function actionIndex(): void
    {
        $model = new Landing('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Landing');

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Landing();
        $model->parent_id = Yii::$app->request->get('parent');

        if ($post = Yii::$app->request->post('Landing')) {
            $model->attributes = $post;

            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id): void
    {
        $model = $this->loadModel($id);

        if ($post = Yii::$app->request->post('Landing')) {
            $model->attributes = $post;

            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
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

    public function loadModel($id): Landing
    {
        $model = Landing::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
