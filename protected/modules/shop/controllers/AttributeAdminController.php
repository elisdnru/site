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
                'attributes'=>array('inshort')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function createModel()
    {
        $model = new ShopProductAttribute();
        $model->type_id = Yii::app()->request->getParam('type');
        return $model;
    }

    public function loadModel($id)
    {
        $model = ShopProductAttribute::model()->findByPk((int)$id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}