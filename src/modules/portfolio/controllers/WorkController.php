<?php

namespace app\modules\portfolio\controllers;

use CHttpException;
use app\modules\portfolio\components\PortfolioBaseController;
use app\modules\portfolio\models\Work;
use Yii;

class WorkController extends PortfolioBaseController
{
    public function actionShow($id): string
    {
        $model = $this->loadModel($id);

        if ('/' . Yii::$app->request->getPathInfo() !== $model->getUrl()) {
            $this->redirect($model->getUrl(), true, 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    protected function loadModel($id): Work
    {
        $query = Work::find();

        if (!Yii::$app->moduleManager->allowed('portfolio')) {
            $query->published();
        }

        $model = $query->andWhere(['id' => $id])->one();

        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }
}
