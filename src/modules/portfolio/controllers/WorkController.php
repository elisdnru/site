<?php

namespace app\modules\portfolio\controllers;

use CHttpException;
use app\modules\portfolio\components\PortfolioBaseController;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;

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
        if ($this->moduleAllowed('portfolio')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = Work::model()->cache(0, new Tags('portfolio'))->findByPk($id, $condition);

        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }
}
