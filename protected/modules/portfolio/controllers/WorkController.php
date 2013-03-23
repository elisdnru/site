<?php

class WorkController extends PortfolioBaseController
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
        if ($this->moduleAllowed('portfolio')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = PortfolioWork::model()->cache(3600*24)->findByPk($id, $condition);

        if($model===null)
            throw new CHttpException(404,'Страница не найдена');

        return $model;
    }
}