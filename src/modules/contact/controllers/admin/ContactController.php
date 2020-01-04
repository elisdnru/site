<?php

namespace app\modules\contact\controllers\admin;

use app\modules\contact\forms\ContactSearch;
use app\modules\contact\models\Contact;
use app\components\AdminController;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ContactController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new ContactSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
            return $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionToggle(int $id, $attribute): ?Response
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'status') {
            throw new BadRequestHttpException('Missing attribute ' . $attribute);
        }

        $model->$attribute = $model->$attribute ? '0' : '1';
        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionView(int $id): string
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

    private function loadModel(int $id): Contact
    {
        $model = Contact::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
