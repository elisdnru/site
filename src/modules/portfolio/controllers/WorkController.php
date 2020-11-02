<?php

namespace app\modules\portfolio\controllers;

use app\modules\portfolio\components\PortfolioBaseController;
use app\modules\portfolio\models\Work;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class WorkController extends PortfolioBaseController
{
    public function actionShow(int $id, $alias = null)
    {
        $model = $this->loadModel($id);

        if ('/' . Yii::$app->request->getPathInfo() !== $model->getUrl()) {
            return $this->redirect(Url::current(['alias' => $model->alias, 'category' => $model->category->getPath()]), 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    private function loadModel(int $id): Work
    {
        $query = Work::find();

        if (!Yii::$app->moduleAccess->isGranted('portfolio')) {
            $query->published();
        }

        $model = $query->andWhere(['id' => $id])->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
