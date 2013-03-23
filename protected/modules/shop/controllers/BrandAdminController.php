<?php

Yii::import('application.modules.crud.components.*');

class BrandAdminController extends DAdminController
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
                'condition'=>'brand_id=:ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($countProducts)
            throw new CHttpException(400, 'У данного производителя есть товары. Удалите их или переместите в другие разделы.');
    }

    public function createModel()
    {
        $model = new ShopBrand();
        return $model;
    }

    public function loadModel($id)
    {
        $model = ShopBrand::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}