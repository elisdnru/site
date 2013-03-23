<?php

Yii::import('gallery.models.*');
Yii::import('crud.components.*');

class SlideAdminController extends DAdminController
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
        $model = new Slide();
        return $model;
	}

    public function loadModel($id)
    {
        $model = Slide::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }
}