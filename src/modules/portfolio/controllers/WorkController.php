<?php

namespace app\modules\portfolio\controllers;

use CHttpException;
use app\modules\portfolio\components\PortfolioBaseController;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;
use Yii;

class WorkController extends PortfolioBaseController
{
    public function actionShow($id): void
    {
        $model = $this->loadModel($id);
        $this->checkUrl($model->url);

        $this->render('show', [
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
