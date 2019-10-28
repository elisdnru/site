<?php

namespace app\modules\comment\components;

use app\modules\comment\models\Comment;
use CActiveRecord;
use CException;
use CHttpException;
use app\components\AdminController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

abstract class CommentAdminController extends AdminController
{
    private const COMMENTS_PER_PAGE = 20;

    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + delete, moder, moderAll',
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

    public function actionUpdate($id): void
    {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        }
        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionToggle($id, $attribute): void
    {
        $model = $this->loadModel($id);

        if (!in_array($attribute, ['public', 'moder'], true)) {
            throw new HttpException(400, 'Missing attribute ' . $attribute);
        }

        $model->$attribute = $model->$attribute ? '0' : '1';
        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
    }

    public function actionView($id): void
    {
        $model = $this->loadModel($id);
        $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id): void
    {
        $model = $this->loadModel($id);

        if ($model->children) {
            $model->public = false;
            $success = $model->save(false);
        } else {
            $success = $model->delete();
        }

        if (!$success) {
            throw new CHttpException(400, 'Error');
        }

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(['index']);
        }
    }

    public function actionModer($id): void
    {
        $model = $this->loadModel($id);

        $model->moder = !$model->moder;

        if (!$model->save()) {
            throw new CHttpException(400, 'Error');
        }

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(['index']);
        }
    }

    public function actionModerAll(): void
    {
        foreach ($this->getModelName()::find()->unread()->each() as $item) {
            $item->moder = 1;
            $item->save();
        }

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(['index']);
        }
    }

    public function loadModel($id): Comment
    {
        /** @var Comment $model */
        $model = $this->getModelName()::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Комментарий не найден');
        }
        return $model;
    }

    protected function loadMaterialModel($id): CActiveRecord
    {
        throw new CException('Undefined material model ' . $id);
    }

    /**
     * @return string|Comment
     */
    protected function getModelName(): string
    {
        return Comment::class;
    }
}
