<?php

declare(strict_types=1);

namespace app\modules\page\controllers\admin;

use app\components\AdminController;
use app\components\category\TreeActiveDataProvider;
use app\components\DataProvider;
use app\modules\page\models\Page;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class PageController extends AdminController
{
    public function actionIndex(): string
    {
        $dataProvider = new DataProvider(new TreeActiveDataProvider([
            'childrenRelation' => 'children',
            'query' => Page::find(),
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
            ],
            'pagination' => false,
        ]));

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new Page();
        $model->date = date('Y-m-d');
        $model->parent_id = $request->get('parent', 0);

        if ($model->load((array)$request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $model = $this->loadModel($id);

        if ($model->load((array)$request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): Response
    {
        $model = $this->loadModel($id);

        return $this->redirect($model->getUrl());
    }

    private function loadModel(int $id): Page
    {
        $model = Page::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
