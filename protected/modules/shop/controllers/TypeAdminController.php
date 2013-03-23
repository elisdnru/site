<?php

Yii::import('application.modules.crud.components.*');

class TypeAdminController extends DAdminController
{
    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DAdminAction',
                'view'=>'index',
                'ajaxView'=>'_grid'
            ),
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('visible')
            ),
            'create'=>'DCreateAction',
            'update'=>'DUpdateAction',
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function beforeDelete($model)
    {
        $countProducts = ShopProduct::model()->count(
            array(
                'condition'=>'type_id=:ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($countProducts)
            throw new CHttpException(400, 'В данном типе есть товары. Удалите их или переместите в другие типы.');

        $countCategories = ShopCategory::model()->count(
            array(
                'condition'=>'type_id=:ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($countCategories)
            throw new CHttpException(400, 'В данном типе есть категории. Удалите их или переместите в другие типы.');
    }

    public function createModel()
    {
        $model = new ShopType();
        return $model;
    }

    public function loadModel($id)
    {
        $model = ShopType::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}