<?php

Yii::import('application.modules.crud.components.*');

class PosttypeAdminController extends DAdminController
{
    public function actions()
    {
        return array(
            'delete'=>'DDeleteAction',
        );
    }

    public function behaviors()
    {
        return array_replace(parent::behaviors(), array(
            'tableInputBehavior'=>array('class'=>'DTableInputBehavior'),
        ));
    }

    public function actionIndex()
    {
        $this->renderTableForm(array(
            'order'=>'t.sort ASC',
            'class'=>'ShopPostType',
            'form'=>'ShopPostTypeForm',
            'view'=>'index',
        ));
    }

    public function loadModel($id)
    {
        $model = ShopPostType::model()->findByPk((int)$id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}