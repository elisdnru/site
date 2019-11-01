<?php

namespace app\modules\page\controllers\admin;

use app\components\AdminController;
use app\modules\page\models\Page;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PageController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new Page('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Page');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Page();
        $model->date = time();
        $model->parent_id = Yii::$app->request->get('parent', 0);

        if ($post = Yii::$app->request->post('Page')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if ($post = Yii::$app->request->post('Page')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
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

    public function loadModel($id): Page
    {
        $model = Page::model()->findByPk($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        if ($model->date === '0000-00-00') {
            $model->date = date('Y-m-d');
        }
        return $model;
    }
}
