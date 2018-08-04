<?php

Yii::import('application.modules.crud.components.*');

class ProfileController extends DController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles'=>array(Access::ROLE_USER),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'index'=>'DUpdateAction',
            'view'=>'DViewAction',
        );
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    public function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='settings-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function loadModel($id)
    {
        $model = User::model()->findByPk(Yii::app()->user->id);
        $model->scenario = 'settings';
        if($model===null)
            throw new CHttpException(403, 'Войдите или зарегистрируйтесь');
        return $model;
    }
}
