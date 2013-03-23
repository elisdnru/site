<?php

Yii::import('crud.components.*');
Yii::import('page.models.*');

class MenuAdminController extends DAdminController
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
                'attributes'=>array('visible')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function createModel()
    {
        $model = new Menu();
        $model->visible = 1;
        return $model;
    }

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled())
            $model = Menu::model()->multilang()->findByPk($id);
        else
            $model = Menu::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }
}