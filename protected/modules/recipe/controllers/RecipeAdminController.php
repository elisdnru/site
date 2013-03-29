<?php

Yii::import('application.modules.gallery.models.*');
Yii::import('application.modules.crud.components.*');

class RecipeAdminController extends DAdminController
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
        $model = new Recipe();
        $model->date = date('Y-m-d H:i:s');
        return $model;
	}

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled())
            $model = Recipe::model()->multilang()->findByPk($id);
        else
            $model = Recipe::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }
}