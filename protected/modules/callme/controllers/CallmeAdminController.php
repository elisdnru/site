<?php

Yii::import('crud.components.*');

class CallmeAdminController extends DAdminController
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
            'toggle'=>array('class'=>'DToggleAction', 'attributes'=>array('readed', 'called')),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

	public function actionView($id)
	{
		$model = $this->loadModel($id);

        $model->readed = 1;
        $model->save();

        $prev = Callme::model()->find(array(
            'condition' => 'id < ?',
            'params' => array($id),
            'order' => 'id DESC',
            'limit' => 1
        ));

        $next = Callme::model()->find(array(
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
        $model = new Callme();
        return $model;
    }

    public function loadModel($id)
    {
        $model = Callme::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}