<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\forms\PostSearch;
use app\modules\blog\models\Post;
use app\components\AdminController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class PostController extends AdminController
{
    public function actionIndex(Request $request): string
    {
        $model = new PostSearch();
        $dataProvider = $model->search($request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(Request $request)
    {
        $model = new Post();
        $model->public = 1;
        $model->image_show = 1;
        $model->image = '';
        $model->category_id = $request->get('category');
        $model->date = date('Y-m-d H:i:s');

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id, Request $request)
    {
        $model = $this->loadModel($id);

        if ($model->load($request->post()) && $model->save()) {
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

    private function loadModel(int $id): Post
    {
        $model = Post::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
