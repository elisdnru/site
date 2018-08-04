<?php

Yii::import('application.modules.page.models.*');
Yii::import('application.modules.crud.components.*');

class LayoutAdminController extends DAdminController
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
        $model = new PageLayout();
        return $model;
    }

    public function loadModel($id)
    {
        $model = PageLayout::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}