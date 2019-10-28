<?php

namespace app\modules\menu\controllers\admin;

use CHttpException;
use app\components\AdminController;
use app\modules\menu\models\Menu;
use Yii;

class MenuController extends AdminController
{
    public function actionIndex(): void
    {
        $model = new Menu('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Menu');

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Menu();
        $model->visible = 1;

        if ($post = Yii::$app->request->post('Menu')) {
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

        if ($post = Yii::$app->request->post('Menu')) {
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

        if ($attribute !== 'visible') {
            throw new CHttpException(400, 'Missing attribute '. $attribute);
        }

        $model->$attribute = $model->$attribute ? 0 : 1;

        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
    }

    public function actionView(): void
    {
        $this->redirect(['index']);
    }

    public function loadModel($id): Menu
    {
        $model = Menu::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
