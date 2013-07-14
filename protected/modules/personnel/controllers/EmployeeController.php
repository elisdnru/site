<?php

class EmployeeController extends PersonnelBaseController
{
    public function actionShow($id)
	{
        $model = $this->loadModel($id);
        $this->checkUrl($model->url);

		$this->render('show', array(
            'model'=>$model,
        ));
	}

    protected function loadModel($id)
    {
        if ($this->moduleAllowed('personnel')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = PersonnelEmployee::model()->cache(0, new Tags('personnel'))->findByPk($id, $condition);

        if($model===null)
            throw new CHttpException(404,'Страница не найдена');

        return $model;
    }
}