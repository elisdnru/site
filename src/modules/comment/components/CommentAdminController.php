<?php

namespace app\modules\comment\components;

use app\modules\comment\models\Comment;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use CException;
use CHttpException;
use app\components\AdminController;

class CommentAdminController extends AdminController
{
    const COMMENTS_PER_PAGE = 20;

    public function filters()
    {
        return array_merge(parent::filters(), [
            'PostOnly + delete, moder, moderAll',
        ]);
    }

    public function actions()
    {
        return [
            'update' => \app\components\crud\actions\UpdateAction::class,
            'toggle' => [
                'class' => \app\components\crud\actions\ToggleAction::class,
                'attributes' => ['public', 'moder']
            ],
            'view' => \app\components\crud\actions\ViewAction::class,
        ];
    }

    public function actionIndex($id = 0)
    {
        $criteria = new CDbCriteria;

        if ($id && $material = $this->loadMaterialModel($id)) {
            $criteria->compare('material_id', $id);
        } else {
            $material = null;
        }

        $dataProvider = new CActiveDataProvider(call_user_func([$this->getModelName(), 'model']), [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.date DESC'
            ],
            'pagination' => [
                'pageSize' => self::COMMENTS_PER_PAGE,
                'pageVar' => 'page',
            ]
        ]);

        $this->render('index', [
            'dataProvider' => $dataProvider,
            'material' => $material,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if ($model->child_items) {
            $model->public = false;
            $success = $model->save(false);
        } else {
            $success = $model->delete();
        }

        if (!$success) {
            throw new CHttpException(400, 'Error');
        }

        $this->redirectOrAjax();
    }

    public function actionModer($id)
    {
        $model = $this->loadModel($id);

        $model->moder = !$model->moder;

        if (!$model->save()) {
            throw new CHttpException(400, 'Error');
        }

        $this->redirectOrAjax();
    }

    public function actionModerAll()
    {
        $items = CActiveRecord::model($this->getModelName())->findAllByAttributes(['moder' => 0]);

        foreach ($items as $item) {
            $item->moder = 1;
            $item->save();
        }

        $this->redirectOrAjax();
    }

    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->getModelName())->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Комментарий не найден');
        }
        return $model;
    }

    protected function loadMaterialModel($id)
    {
        throw new CException('Undefined material model');
    }

    protected function getModelName()
    {
        return Comment::class;
    }
}
