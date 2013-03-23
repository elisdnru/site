<?php

Yii::import('application.modules.crud.components.*');

class BlockAdminController extends DAdminController
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
        return new Block();
    }

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled())
            $model = Block::model()->multilang()->findByPk($id);
        else
            $model = Block::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}