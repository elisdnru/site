<?php

declare(strict_types=1);

namespace app\modules\blog\controllers\admin;

use app\components\AdminController;
use app\modules\blog\forms\admin\TagForm;
use app\modules\blog\models\Tag;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class TagController extends AdminController
{
    public function actionIndex(): string
    {
        $tags = Tag::find()->orderBy(['title' => SORT_ASC])->all();

        return $this->render('index', [
            'tags' => $tags,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new TagForm();

        if ($model->load((array)$request->post()) && $model->validate()) {
            $tag = new Tag();
            $tag->title = $model->title;
            $tag->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $tag = $this->loadModel($id);
        $model = new TagForm($tag);

        if ($model->load((array)$request->post()) && $model->validate()) {
            $tag->title = $model->title;
            $tag->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'tag' => $tag,
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $tag = $this->loadModel($id);
        $tag->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    private function loadModel(int $id): Tag
    {
        $model = Tag::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
