<?php

Yii::import('application.modules.crud.components.*');

class EmployeeAdminController extends DAdminController
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
                'attributes'=>array('public')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function createModel()
    {
        $model = new PersonnelEmployee();
        $model->public = 1;
        $model->image_show = 1;
        $model->category_id = Yii::app()->request->getQuery('category');
        return $model;
    }

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled())
            $model = PersonnelEmployee::model()->multilang()->findByPk($id);
        else
            $model = PersonnelEmployee::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}