<?php

Yii::import('application.modules.crud.components.*');

class PhotoAdminController extends DAdminController
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
                'attributes'=>array('public')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function createModel()
    {
        $model = new GalleryPhoto();
        $model->public = 1;
        $model->category_id = Yii::app()->request->getParam('category');
        $model->date = date('Y-m-d H:i:s');
        return $model;
    }

    public function loadModel($id)
    {
        $model = GalleryPhoto::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}