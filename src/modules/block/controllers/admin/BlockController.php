<?php

declare(strict_types=1);

namespace app\modules\block\controllers\admin;

use app\components\AdminController;
use app\modules\block\forms\admin\BlockForm;
use app\modules\block\models\Block;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class BlockController extends AdminController
{
    public function actionIndex(): string
    {
        $blocks = Block::find()->orderBy(['title' => SORT_ASC])->all();

        return $this->render('index', [
            'blocks' => $blocks,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new BlockForm();
        if ($model->load((array)$request->post()) && $model->validate()) {
            $block = new Block();
            $block->slug = $model->slug;
            $block->title = $model->title;
            $block->text = $model->text;
            if ($block->save()) {
                return $this->redirect(['view', 'id' => $block->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $block = $this->loadModel($id);
        $model = new BlockForm($block);
        if ($model->load((array)$request->post()) && $model->validate()) {
            $block->slug = $model->slug;
            $block->title = $model->title;
            $block->text = $model->text;
            if ($block->save()) {
                return $this->redirect(['view', 'id' => $block->id]);
            }
        }
        return $this->render('update', [
            'block' => $block,
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $block = $this->loadModel($id);
        $block->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): string
    {
        $block = $this->loadModel($id);
        return $this->render('view', [
            'block' => $block,
        ]);
    }

    public function loadModel(int $id): Block
    {
        $model = Block::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
