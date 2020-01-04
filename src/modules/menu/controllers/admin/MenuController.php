<?php

namespace app\modules\menu\controllers\admin;

use app\components\AdminController;
use app\modules\menu\models\Menu;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MenuController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new Menu('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Menu');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Menu();
        $model->visible = 1;

        if ($post = Yii::$app->request->post('Menu')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $model = $this->loadModel($id);

        if ($post = Yii::$app->request->post('Menu')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionToggle(int $id, $attribute): ?Response
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'visible') {
            throw new BadRequestHttpException('Missing attribute '. $attribute);
        }

        $model->$attribute = $model->$attribute ? 0 : 1;

        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionView(): Response
    {
        return $this->redirect(['index']);
    }

    private function loadModel(int $id): Menu
    {
        $model = Menu::model()->findByPk($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
