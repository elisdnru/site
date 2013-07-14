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
        $count = PersonnelEmployee::model()->count(
            array(
                'condition'=>'t.category_id = :ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($count)
            throw new CHttpException(400, 'В данной группе есть записи. Удалите их или переместите в другие категории.');
    }

    public function createModel()
    {
        return new PersonnelCategory();
    }

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled())
            $model = PersonnelCategory::model()->multilang()->findByPk($id);
        else
            $model = PersonnelCategory::model()->findByPk($id);
        
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}