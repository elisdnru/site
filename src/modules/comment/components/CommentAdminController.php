<?php

namespace app\modules\comment\components;

use app\modules\comment\models\Comment;
use BadMethodCallException;
use CActiveRecord;
use app\components\AdminController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
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

    public function actionIndex($id = 0): string
    {
        $query = $this->getModelName()::find();

        if ($id && $material = $this->loadMaterialModel($id)) {
            $query->material($id);
        } else {
            $material = null;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['date' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => self::COMMENTS_PER_PAGE,
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'material' => $material,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionToggle($id, $attribute): ?Response
    {
        $model = $this->loadModel($id);

        if (!in_array($attribute, ['public', 'moder'], true)) {
            throw new BadRequestHttpException('Missing attribute ' . $attribute);
        }

        $model->$attribute = $model->$attribute ? '0' : '1';
        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionView($id): string
    {
        $model = $this->loadModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id): ?Response
    {
        $model = $this->loadModel($id);

        if ($model->children) {
            $model->public = false;
            $success = $model->save(false);
        } else {
            $success = $model->delete();
        }

        if (!$success) {
            throw new BadRequestHttpException('Error');
        }

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionModer($id): ?Response
    {
        $model = $this->loadModel($id);

        $model->moder = !$model->moder;

        if (!$model->save()) {
            throw new BadRequestHttpException('Error');
        }

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionModerAll(): ?Response
    {
        foreach ($this->getModelName()::find()->unread()->each() as $item) {
            $item->moder = 1;
            $item->save();
        }

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function loadModel($id): Comment
    {
        /** @var Comment $model */
        $model = $this->getModelName()::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    protected function loadMaterialModel($id): CActiveRecord
    {
        throw new BadMethodCallException('Undefined material model ' . $id);
    }

    /**
     * @return string|Comment
     */
    protected function getModelName(): string
    {
        return Comment::class;
    }
}
