<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Tag;
use CHttpException;
use app\components\AdminController;
use Yii;

class TagController extends AdminController
{
    public function actionIndex(): void
    {
        $model = new Tag('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Tag');

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Tag();

        if ($post = Yii::$app->request->post('Tag')) {
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

        if ($post = Yii::$app->request->post('Tag')) {
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

    public function actionView(): void
    {
        $this->redirect(['index']);
    }

    public function loadModel($id): Tag
    {
        $model = Tag::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
