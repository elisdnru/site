<?php

Yii::import('crud.components.*');

class CategoryAdminController extends DAdminController
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

    public function beforeDelete($model)
    {
        $countProducts = ShopProduct::model()->count(
            array(
                'condition'=>'rubrika_id=:ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($countProducts)
            throw new CHttpException(400, 'В данной рубрике есть товары. Удалите их или переместите в другие типы.');
    }

    public function createModel()
    {
        $model = new RubrikatorCategory();
        return $model;
    }

    public function loadModel($id)
    {
        $model = RubrikatorCategory::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}