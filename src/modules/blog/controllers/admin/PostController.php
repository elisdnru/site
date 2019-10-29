<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Post;
use app\components\AdminController;
use Yii;
use yii\web\HttpException;
use yii\web\Response;

class PostController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new Post('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Post');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
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

        if ($post = Yii::$app->request->post('Post')) {
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

    public function actionToggle($id, $attribute): ?Response
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'public') {
            throw new HttpException(400, 'Missing attribute '. $attribute);
        }

        $model->$attribute = $model->$attribute ? 0 : 1;

        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionView($id): Response
    {
        $model = $this->loadModel($id);

        return $this->redirect($model->getUrl());
    }

    public function loadModel($id): Post
    {
        $model = Post::model()->findByPk($id);
        if ($model === null) {
            throw new HttpException(404, 'Не найдено');
        }
        return $model;
    }
}
