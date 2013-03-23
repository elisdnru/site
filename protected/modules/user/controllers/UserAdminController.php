<?php

Yii::import('page.models.*');
Yii::import('crud.components.*');

class UserAdminController extends DAdminController
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
            'update'=>'DUpdateAction',
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('active')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function actionAccessAdd($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['AccessPage']))
        {
            if ($page = Page::model()->findByPk($_POST['AccessPage']['page']))
            {
                $userPage = UserPage::model()->find(array(
                    'condition'=>'user_id=:user AND page_id=:page',
                    'params'=>array(':user'=>$model->id, ':page'=>$page->id)
                ));

                if (!$userPage){
                    $userPage = new UserPage();
                    $userPage->page_id = $page->id;
                    $userPage->user_id = $model->id;
                    if($userPage->save()){
                        Yii::app()->user->setFlash('success', 'Раздел добавлен');
                        $this->refresh();
                    }
                }
            }
        }

        $this->redirect($this->createUrl('update', array('id'=>$id)));
    }

    public function actionAccessDel($id)
    {
        $this->checkIsPost();

        $model = $this->loadAccessPageModel($id);

        if (!$model->delete())
            throw new CHttpException(400, 'Ошибка удаления');

        $this->redirectOrAjax();
    }
    public function createModel()
    {
        $model = new User(User::SCENARIO_ADMIN_CREATE);
        return $model;
    }

    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        $model->scenario = User::SCENARIO_ADMIN_UPDATE;
        return $model;
    }

    protected function loadAccessPageModel($id)
    {
        $model = UserPage::model()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }

    public function performAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}