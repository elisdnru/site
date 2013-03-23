<?php

Yii::import('crud.components.*');

class GroupAdminController extends DAdminController
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
            'class'=>'NewsGroup',
            'order'=>'title ASC',
            'form'=>'NewsGroupForm',
            'view'=>'index',
        ));
    }

    public function beforeDelete($model)
    {
        $count = News::model()->count(
            array(
                'condition'=>'t.group_id = :ID',
                'params'=>array(':ID'=>$model->id)
            )
        );

        if ($count)
            throw new CHttpException(400, 'В данной группе есть новости. Удалите их или переместите в другие группы.');
    }

    public function loadModel($id)
    {
        $model = NewsGroup::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}