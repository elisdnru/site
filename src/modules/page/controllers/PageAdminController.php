<?php

Yii::import('application.modules.crud.components.*');

class PageAdminController extends DAdminController
{
    public function filters()
    {
        return array_merge(parent::filters(), [
            'PostOnly + deleteFile',
        ]);
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => 'DAdminAction',
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => 'DCreateAction',
            'update' => 'DUpdateAction',
            'delete' => 'DDeleteAction',
            'view' => 'DViewAction',
        ];
    }

    public function beforeUpdate($model)
    {
        $user = $this->getUser();
        if (!$model->allowedForUser($user)) {
            throw new CHttpException(403, 'Отказано в доступе');
        }
    }

    public function beforeDelete($model)
    {
        $user = $this->getUser();
        if ($model->system || !$model->allowedForUser($user)) {
            throw new CHttpException(403, 'Отказано в доступе');
        }
    }

    public function actionDeleteFile($id)
    {
        if (!$model = PageFile::model()->findByPk($id)) {
            throw new CHttpException(404, 'Не найдено');
        }

        if (!$model->delete()) {
            throw new CHttpException(400, 'Ошибка удаления');
        }

        $this->redirectOrAjax();
    }

    public function createModel()
    {
        $model = new Page();
        $model->parent_id = Yii::app()->request->getParam('parent', 0);
        return $model;
    }

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled()) {
            $model = Page::model()->multilang()->findByPk($id);
        } else {
            $model = Page::model()->findByPk($id);
        }

        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
