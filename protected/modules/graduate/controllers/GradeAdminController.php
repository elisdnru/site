<?php

Yii::import('application.modules.crud.components.*');

class GradeAdminController extends DAdminController
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
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function createModel()
    {
        return new GraduateGrade();
    }

    public function loadModel($id)
    {
        $model = GraduateGrade::model()->findByPk($id);
        
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}