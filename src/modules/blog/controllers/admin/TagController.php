<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Tag;
use app\components\AdminController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TagController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new Tag('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Tag');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Tag();

        if ($post = Yii::$app->request->post('Tag')) {
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

        if ($post = Yii::$app->request->post('Tag')) {
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

    public function actionView(): Response
    {
        return $this->redirect(['index']);
    }

    public function loadModel($id): Tag
    {
        $model = Tag::model()->findByPk($id);

        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
