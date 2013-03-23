<?php

Yii::import('crud.components.*');

class ContactAdminController extends DAdminController
{
    const CONTACTS_PER_PAGE = 50;

    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DAdminAction',
                'view'=>'index',
                'ajaxView'=>'_grid'
            ),
            'toggle'=>array('class'=>'DToggleAction', 'attributes'=>array('status')),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

	public function actionView($id)
	{
		$model = $this->loadModel($id);

        $model->status = 1;
        $model->save();

        $prev = Contact::model()->find(array(
            'condition' => 'id < ?',
            'params' => array($id),
            'order' => 'id DESC',
            'limit' => 1
        ));

        $next = Contact::model()->find(array(
            'condition' => 'id > ?',
            'params' => array($id),
            'order' => 'id ASC',
            'limit' => 1
        ));

		$this->render('view',array(
            'model'=>$model,
            'prev'=>$prev,
            'next'=>$next,
        ));
	}

    public function createModel()
    {
        $model = new Contact();
        return $model;
    }

    public function loadModel($id)
    {
        $model = Contact::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}