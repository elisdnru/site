<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Post;
use CHttpException;
use app\components\AdminController;
use Yii;

class PostController extends AdminController
{
    public function actionIndex(): void
    {
        $model = new Post('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Post');

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Post();
        $model->public = 1;
        $model->image_show = 1;
        $model->image = '';
        $model->category_id = Yii::$app->request->get('category');
        $model->date = date('Y-m-d H:i:s');

        if ($post = Yii::$app->request->post('Post')) {
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

        if ($post = Yii::$app->request->post('Post')) {
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

    public function actionToggle($id, $attribute): void
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'public') {
            throw new CHttpException(400, 'Missing attribute '. $attribute);
        }

        $model->$attribute = $model->$attribute ? 0 : 1;

        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
    }

    public function actionView($id): void
    {
        $model = $this->loadModel($id);

        $this->redirect($model->getUrl());
    }

    public function loadModel($id): Post
    {
        $model = Post::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
