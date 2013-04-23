<?php

Yii::import('application.modules.crud.components.*');

class ModelAdminController extends DAdminController
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
        $model = new ShopModel();

        if (isset($_GET['ShopModel']['product_id']))
            $model->product_id = $_GET['ShopModel']['product_id'];

        return $model;
    }

    public function loadModel($id)
    {
        $model = ShopModel::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}