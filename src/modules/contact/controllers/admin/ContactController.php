<?php

namespace app\modules\contact\controllers\admin;

use app\modules\contact\forms\ContactSearch;
use CHttpException;
use app\modules\contact\models\Contact;
use app\components\AdminController;
use Yii;
use yii\web\HttpException;

class ContactController extends AdminController
{
    public function actionIndex(): void
    {
        $model = new ContactSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionUpdate($id): void
    {
        $model = $this->loadModel($id);
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
            $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
    }

    public function actionToggle($id, $attribute): void
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'status') {
            throw new HttpException(400, 'Missing attribute ' . $attribute);
        }

        $model->$attribute = $model->$attribute ? '0' : '1';
        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
    }

    public function actionView($id): string
    {
        $model = $this->loadModel($id);

        $prev = Contact::find()->andWhere(['<', 'id', $id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        $next = Contact::find()->andWhere(['>', 'id', $id])->orderBy(['id' => SORT_ASC])->limit(1)->one();

        return $this->render('view', [
            'model' => $model,
            'prev' => $prev,
            'next' => $next,
        ]);
    }

    public function createModel(): Contact
    {
        return new Contact();
    }

    public function createSearchModel(): ContactSearch
    {
        return new ContactSearch();
    }

    public function loadModel($id): Contact
    {
        $model = Contact::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
