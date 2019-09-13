<?php

namespace app\modules\portfolio\controllers;

use CHttpException;
use app\modules\portfolio\components\PortfolioBaseController;
use PortfolioWork;
use Tags;

class WorkController extends PortfolioBaseController
{
    public function actionShow($id)
    {
        $model = $this->loadModel($id);
        $this->checkUrl($model->url);

        $this->render('show', [
            'model' => $model,
        ]);
    }

    protected function loadModel($id)
    {
        if ($this->moduleAllowed('portfolio')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = PortfolioWork::model()->cache(0, new Tags('portfolio'))->findByPk($id, $condition);

        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }
}
