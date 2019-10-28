<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use CHttpException;
use app\components\AdminController;
use Yii;

class CategoryController extends AdminController
{
    public function actionIndex(): void
    {
        $model = new Category('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Category');

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Category();

        if ($post = Yii::$app->request->post('Category')) {
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

        if ($post = Yii::$app->request->post('Category')) {
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

        $count = Post::model()->count([
            'condition' => 't.category_id = :id',
            'params' => [':id' => $model->id]
        ]);

        if ($count) {
            throw new CHttpException(402, 'В данной группе есть записи. Удалите их или переместите в другие категории.');
        }

        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(['index']);
        }
    }

    public function actionView(): void
    {
        $this->redirect(['index']);
    }

    public function loadModel($id): Category
    {
        $model = Category::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
