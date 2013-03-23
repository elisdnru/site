<?php

Yii::import('application.modules.crud.components.*');

class AttributeAdminController extends DAdminController
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
                'attributes'=>array('required')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function createModel()
    {
        $model = new UserAttribute();
        $model->class = Yii::app()->request->getParam('class');
        return $model;
    }

    public function loadModel($id)
    {
        $model = UserAttribute::model()->findByPk((int)$id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}