<?php

namespace app\modules\page\controllers\admin;

use CHttpException;
use app\components\AdminController;
use app\modules\page\models\Page;
use Yii;

class PageController extends AdminController
{
    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + deleteFile',
        ]);
    }

    public function actionIndex(): void
    {
        $model = new Page('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Page');

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Page();
        $model->date = time();
        $model->parent_id = Yii::$app->request->get('parent', 0);

        if ($post = Yii::$app->request->post('Page')) {
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

        if ($post = Yii::$app->request->post('Page')) {
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

    public function loadModel($id): Page
    {
        $model = Page::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        if ($model->date === '0000-00-00') {
            $model->date = date('Y-m-d');
        }
        return $model;
    }
}
