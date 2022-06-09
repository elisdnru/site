<?php

declare(strict_types=1);

namespace app\modules\comment\components;

use app\components\AdminController;
use app\components\DataProvider;
use app\modules\comment\forms\admin\CommentUpdateForm;
use app\modules\comment\models\Comment;
use BadMethodCallException;
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
        $query = Comment::find();

        if ($id && $material = $this->loadMaterialModel($id)) {
            $query->type($this->getType())->material($id);
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
            ],
        ]));

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'material' => $material,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $comment = $this->loadModel($id);
        $model = new CommentUpdateForm($comment);

        if ($model->load((array)$request->post()) && $model->validate()) {
            $comment->date = $model->date;
            $comment->name = $model->name;
            $comment->email = $model->email;
            $comment->site = $model->site;
            $comment->text = $model->text;
            $comment->parent_id = $model->parent_id ? (int)$model->parent_id : null;
            if ($comment->save()) {
                return $this->redirect(['view', 'id' => $comment->id]);
            }
        }

        return $this->render('update', [
            'comment' => $comment,
            'model' => $model,
        ]);
    }

    public function actionToggle(int $id, string $attribute, Request $request): ?Response
    {
        $comment = $this->loadModel($id);

        if (!\in_array($attribute, ['public', 'moder'], true)) {
            throw new BadRequestHttpException('Missing attribute ' . $attribute);
        }

        $comment->{$attribute} = $comment->{$attribute} ? '0' : '1';
        $comment->save();

        if (!$request->getIsAjax()) {
            return $this->redirect($request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionView(int $id): string
    {
        $comment = $this->loadModel($id);
        return $this->render('view', [
            'comment' => $comment,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $comment = $this->loadModel($id);

        if ($comment->children) {
            $comment->public = 0;
            $success = $comment->save(false);
        } else {
            $success = $comment->delete();
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
        $comment = $this->loadModel($id);

        $comment->moder = $comment->moder ? 0 : 1;

        if (!$comment->save()) {
            throw new BadRequestHttpException('Error');
        }

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionModerAll(Request $request): ?Response
    {
        foreach (Comment::find()->type($this->getType())->unread()->each() as $item) {
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
        $model = Comment::findOne($id);
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
     * @return ActiveRecord|string
     * @psalm-return class-string<ActiveRecord>
     */
    protected function getType(): ?string
    {
        return null;
    }
}
