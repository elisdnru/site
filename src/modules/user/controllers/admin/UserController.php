<?php

namespace app\modules\user\controllers\admin;

use app\modules\user\forms\UserSearch;
use app\components\AdminController;
use app\modules\user\models\User;
use Yii;
use yii\web\HttpException;
use yii\web\Response;

class UserController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new UserSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new User(['scenario' => User::SCENARIO_ADMIN_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->scenario = User::SCENARIO_ADMIN_UPDATE;
        if ($model->last_visit_datetime === '0000-00-00 00:00:00') {
            $model->last_visit_datetime = null;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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

    public function actionView($id): string
    {
        $model = $this->loadModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function loadModel($id): User
    {
        $model = User::findOne($id);
        if ($model === null) {
            throw new HttpException(404, 'Не найдено');
        }
        return $model;
    }
}
