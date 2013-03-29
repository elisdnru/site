<?php

Yii::import('application.modules.page.models.*');
Yii::import('application.modules.gallery.models.*');
Yii::import('application.modules.crud.components.*');

class NewAdminController extends DAdminController
{
    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DAdminAction',
                'view'=>'index',
                'ajaxView'=>'_grid'
            ),
            'create'=>'DCreateAction',
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('inhome', 'important', 'public')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function beforeCreate($model)
    {
        $user = $this->getUser();

        if ($user->access_pages)
        {
            $page = Page::model()->findByPk($model->page_id);

            if ($page && !$page->allowedForUser($user))
                $model->addError('parent_id', 'Вы не можете добавлять новости на эту страницу');
        }
    }

    public function actionUpdate($id)
    {
        $user = $this->getUser();

        $model = $this->loadModel($id);

        if ($model->page && !$model->page->allowedForUser($user))
            $this->redirect(array('index'));

        if(isset($_POST['News']))
        {
            $access = true;

            if ($user->access_pages)
            {
                $access = false;
                $page = Page::model()->findByPk($_POST['News']['page_id']);
                if ($page && $page->allowedForUser($user)){
                    $access = true;
                }
            }

            if ($access)
            {
                $model->attributes = $_POST['News'];

                if (!$model->author_id)
                    $model->author_id = $user->id;

                if($model->save())
                {
                    Yii::app()->user->setFlash('success', 'Изменения сохранены');
                    $this->redirect($model->url ? $model->url : array('index'));
                }
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'user'=>$user,
        ));
    }

    public function beforeDelete($model)
    {
        $user = $this->getUser();

        if ($user && $user->access_pages && !$model->page->allowedForUser($user))
            throw new CHttpException(403, 'Отказано в доступе');
    }

    public function actionFiledel($id)
    {
        if (!Yii::app()->request->isPostRequest)
            throw new CHttpException (400, 'Некорректный запрос');

        if (!$model = NewsFile::model()->findByPk($id))
            throw new CHttpException(404, 'Файл не найден');

        if (!$model->delete())
            throw new CHttpException(400, 'Ошибка удаления');

        if (!Yii::app()->request->isAjaxRequest)
            $this->controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function createModel()
    {
        $model = new News;
        $model->public = 1;
        $model->image_show = 1;
        $model->inhome = 1;
        $model->page_id = Yii::app()->request->getParam('category', 0);
        $model->date = date('Y-m-d H:i:s');
        return $model;
    }

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled())
            $model = News::model()->multilang()->findByPk($id);
        else
            $model = News::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'new-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}