<?php

namespace app\modules\portfolio\controllers;

use app\modules\portfolio\components\PortfolioBaseController;
use app\modules\portfolio\models\Work;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class WorkController extends PortfolioBaseController
{
    public function actionShow(int $id, ?string $alias = null, Request $request)
    {
        $model = $this->loadModel($id);

        if ('/' . $request->getPathInfo() !== $model->getUrl()) {
            return $this->redirect(Url::current(['alias' => $model->alias, 'category' => $model->category->getPath()]), 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    private function loadModel(int $id): Work
    {
        $query = Work::find();

        if (!Yii::$app->moduleAdminAccess->isGranted('portfolio')) {
            $query->published();
        }

        $model = $query->andWhere(['id' => $id])->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
