<?php

namespace app\modules\landing\controllers\admin;

use app\components\AdminController;
use app\modules\landing\models\Landing;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class LandingController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new Landing('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Landing');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Landing();
        $model->parent_id = Yii::$app->request->get('parent');

        if ($post = Yii::$app->request->post('Landing')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if ($post = Yii::$app->request->post('Landing')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
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

    public function actionView($id): Response
    {
        $model = $this->loadModel($id);

        return $this->redirect($model->getUrl());
    }

    private function loadModel($id): Landing
    {
        $model = Landing::model()->findByPk($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
