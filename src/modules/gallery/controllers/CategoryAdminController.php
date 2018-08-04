<?php

Yii::import('application.modules.crud.components.*');

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
        $count = GalleryPhoto::model()->count(
            array(
                'condition'=>'t.category_id = :id',
                'params'=>array(':id'=>$model->id)
            )
        );

        if ($count)
            throw new CHttpException(402, 'В данной группе есть материалы. Удалите их или переместите в другие категории.');
    }

    public function createModel()
    {
        return new GalleryCategory();
    }

    public function loadModel($id)
    {
        $model = GalleryCategory::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}