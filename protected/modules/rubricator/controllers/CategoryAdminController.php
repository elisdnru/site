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
        $countProducts = RubricatorArticle::model()->count(
            array(
                'condition'=>'category_id=:ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($countProducts)
            throw new CHttpException(400, 'В данной рубрике есть статьи. Удалите их или переместите в другие категории.');
    }

    public function createModel()
    {
        $model = new RubricatorCategory();
        return $model;
    }

    public function loadModel($id)
    {
        if (DMultilangHelper::enabled())
            $model = RubricatorCategory::model()->multilang()->findByPk($id);
        else
            $model = RubricatorCategory::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}