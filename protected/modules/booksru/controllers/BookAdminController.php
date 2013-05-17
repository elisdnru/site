<?php

Yii::import('application.modules.crud.components.*');

class BookAdminController extends DAdminController
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
                'attributes'=>array('free')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

	public function createModel()
    {
        $model = new Book();
        $model->free = 1;
        return $model;
	}

    public function loadModel($id)
    {
        $model = Book::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }
}