<?php

declare(strict_types=1);

namespace app\modules\landing\controllers\admin;

use app\components\AdminController;
use app\components\category\TreeActiveDataProvider;
use app\components\DataProvider;
use app\modules\landing\forms\admin\LandingForm;
use app\modules\landing\models\Landing;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class LandingController extends AdminController
{
    public function actionIndex(): string
    {
        $dataProvider = new DataProvider(new TreeActiveDataProvider([
            'childrenRelation' => 'children',
            'query' => Landing::find(),
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
        /** @var string|null $parent */
        $parent = $request->get('parent');

        $model = new LandingForm();
        $model->parent_id = $parent ? (int)$parent : null;

        if ($model->load((array)$request->post()) && $model->validate()) {
            $landing = new Landing();

            $landing->slug = $model->slug;
            $landing->title = $model->title;
            $landing->text = $model->text;
            $landing->parent_id = $model->parent_id;
            $landing->system = (bool)$model->system;

            $landing->save();
            return $this->redirect(['update', 'id' => $landing->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $landing = $this->loadModel($id);
        $model = new LandingForm($landing);

        if ($model->load((array)$request->post()) && $model->validate()) {
            $landing->slug = $model->slug;
            $landing->title = $model->title;
            $landing->text = $model->text;
            $landing->parent_id = $model->parent_id ? (int)$model->parent_id : null;
            $landing->system = (bool)$model->system;

            $landing->save();
            return $this->redirect(['update', 'id' => $landing->id]);
        }

        return $this->render('update', [
            'landing' => $landing,
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $landing = $this->loadModel($id);
        $landing->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): Response
    {
        $landing = $this->loadModel($id);

        return $this->redirect(['/landing/landing/show', 'path' => $landing->getPath()]);
    }

    private function loadModel(int $id): Landing
    {
        $model = Landing::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
