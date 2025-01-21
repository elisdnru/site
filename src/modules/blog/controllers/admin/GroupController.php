<?php

declare(strict_types=1);

namespace app\modules\blog\controllers\admin;

use app\components\AdminController;
use app\modules\blog\forms\admin\GroupForm;
use app\modules\blog\models\Group;
use app\modules\blog\models\Post;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

/**
 * @psalm-api
 */
final class GroupController extends AdminController
{
    public function actionIndex(): string
    {
        $groups = Group::find()->orderBy(['title' => SORT_ASC])->all();

        return $this->render('index', [
            'groups' => $groups,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        $model = new GroupForm();

        if ($model->load((array)$request->post()) && $model->validate()) {
            $group = new Group();
            $group->title = $model->title;
            $group->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $group = $this->loadModel($id);
        $model = new GroupForm($group);

        if ($model->load((array)$request->post()) && $model->validate()) {
            $group->title = $model->title;
            $group->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'group' => $group,
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $group = $this->loadModel($id);

        $count = Post::find()->andWhere(['group_id' => $group->id])->count();

        if ($count) {
            throw new BadRequestHttpException(
                'В данной группе есть записи. Удалите их или переместите в другие категории.'
            );
        }

        $group->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    private function loadModel(int $id): Group
    {
        $model = Group::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
