<?php

namespace app\modules\comment\components;

use app\components\DataProvider;
use app\modules\comment\models\Comment;
use BadMethodCallException;
use app\components\AdminController;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

abstract class CommentAdminController extends AdminController
{
    private const COMMENTS_PER_PAGE = 20;

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'moder' => ['post'],
                    'moderAll' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex(int $id = 0): string
    {
        $query = $this->getModelName()::find();

        if ($id && $material = $this->loadMaterialModel($id)) {
            $query->material($id);
        } else {
            $material = null;
        }

        $dataProvider = new DataProvider(new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['date' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => self::COMMENTS_PER_PAGE,
            ]
        ]));

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'material' => $material,
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

    public function actionToggle(int $id, string $attribute, Request $request): ?Response
    {
        $model = $this->loadModel($id);

        if (!in_array($attribute, ['public', 'moder'], true)) {
            throw new BadRequestHttpException('Missing attribute ' . $attribute);
        }

        $model->$attribute = $model->$attribute ? '0' : '1';
        $model->save();

        if (!$request->getIsAjax()) {
            return $this->redirect($request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionView(int $id): string
    {
        $model = $this->loadModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);

        if ($model->children) {
            $model->public = 0;
            $success = $model->save(false);
        } else {
            $success = $model->delete();
        }

        if (!$success) {
            throw new BadRequestHttpException('Error');
        }

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionModer(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);

        $model->moder = $model->moder ? 0 : 1;

        if (!$model->save()) {
            throw new BadRequestHttpException('Error');
        }

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionModerAll(Request $request): ?Response
    {
        foreach ($this->getModelName()::find()->unread()->each() as $item) {
            $item->moder = 1;
            $item->save();
        }

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function loadModel(int $id): Comment
    {
        $model = $this->getModelName()::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    protected function loadMaterialModel(int $id): ActiveRecord
    {
        throw new BadMethodCallException('Undefined material model ' . $id);
    }

    /**
     * @return string|Comment
     * @psalm-return class-string<Comment>
     */
    protected function getModelName(): string
    {
        return Comment::class;
    }
}
