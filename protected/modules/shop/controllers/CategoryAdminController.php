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

    public function actionGetCategories()
    {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException(400, 'Некорректный запрос');

        $html = '';
        if (isset($_POST['type']) && (int)$_POST['type'])
        {
            $list = CHtml::dropDownList('category', '', array(''=>'') + ShopCategory::model()->type($_POST['type'])->getTabList());
            $html = strip_tags($list, '<option>');
        }
        echo $html;

        Yii::app()->end();
    }

    public function beforeDelete($model)
    {
        $countProducts = ShopProduct::model()->count(
            array(
                'condition'=>'category_id=:ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($countProducts)
            throw new CHttpException(400, 'В данной категории есть товары. Удалите их или переместите в другие группы.');

        $countSubs = ShopCategory::model()->count(
            array(
                'condition'=>'parent_id=:ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($countSubs)
            throw new CHttpException(400, 'В данной категории есть другие категории. Удалите их или переместите в другие группы.');
    }

    public function createModel()
    {
        return new ShopCategory();
    }

    public function loadModel($id)
    {
        $model = ShopCategory::model()->findByPk((int)$id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}