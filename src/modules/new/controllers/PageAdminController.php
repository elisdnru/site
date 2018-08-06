<?php

Yii::import('application.modules.page.models.*');
Yii::import('application.modules.crud.components.*');

class PageAdminController extends DAdminController
{
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

    public function beforeDelete($model)
    {
        $user = $this->getUser();

        if ($user && $model->page && !$model->page->allowedForUser($user)) {
            throw new CHttpException(403, 'Отказано в доступе');
        }
    }


    public function createModel()
    {
        $model = new NewsPage();
        return $model;
    }

    public function loadModel($id)
    {
        $model = NewsPage::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
