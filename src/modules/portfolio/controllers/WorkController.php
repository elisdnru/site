<?php

namespace app\modules\portfolio\controllers;

use yii\base\InvalidConfigException;
use yii\web\Controller;
use app\components\module\admin\AdminAccess;
use app\modules\portfolio\models\Work;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class WorkController extends Controller
{
    /**
     * @param int $id
     * @param Request $request
     * @param AdminAccess $access
     * @param string|null $alias
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public function actionShow(int $id, Request $request, AdminAccess $access, ?string $alias = null)
    {
        $model = $this->loadModel($id, $access);

        if ('/' . $request->getPathInfo() !== $model->getUrl()) {
            return $this->redirect(Url::current(['alias' => $model->alias, 'category' => $model->category->getPath()]), 301);
        }

        return $this->render('show', [
            'model' => $model,
        ]);
    }

    private function loadModel(int $id, AdminAccess $access): Work
    {
        $query = Work::find();

        if (!$access->isGranted('portfolio')) {
            $query->published();
        }

        $model = $query->andWhere(['id' => $id])->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
