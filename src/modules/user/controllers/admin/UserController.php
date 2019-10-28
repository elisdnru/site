<?php

namespace app\modules\user\controllers\admin;

use app\modules\user\forms\UserSearch;
use CHttpException;
use app\components\AdminController;
use app\modules\user\models\User;
use Yii;

class UserController extends AdminController
{
    public function actionIndex(): void
    {
        $model = new UserSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate(): void
    {
        $model = new User(['scenario' => User::SCENARIO_ADMIN_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        }
        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id): void
    {
        $model = $this->loadModel($id);
        $model->scenario = User::SCENARIO_ADMIN_UPDATE;
        if ($model->last_visit_datetime === '0000-00-00 00:00:00') {
            $model->last_visit_datetime = null;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
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

    public function loadModel($id): User
    {
        $model = User::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
