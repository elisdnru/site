<?php

namespace app\modules\portfolio\controllers\admin;

use app\components\AdminController;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use Yii;
use yii\web\HttpException;
use yii\web\Response;

class CategoryController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new Category('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Category');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        if ($post = Yii::$app->request->post('Category')) {
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

        if ($post = Yii::$app->request->post('Category')) {
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

        $count = Work::find()->category($model->id)->count();
        if ($count) {
            throw new HttpException(400, 'В данной группе есть записи. Удалите их или переместите в другие категории.');
        }

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

    public function loadModel($id): Category
    {
        $model = Category::model()->findByPk($id);
        if ($model === null) {
            throw new HttpException(404, 'Не найдено');
        }
        return $model;
    }
}
