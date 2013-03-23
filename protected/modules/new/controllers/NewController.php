<?php

class NewController extends DController
{
	public function actionShow($id)
	{
		$model = $this->loadModel($id);
        $this->checkUrl($model->url);

        if (!$layout = NewsPage::model()->getShowLayout($model->page->id))
            $layout = 'default';

        $this->layout = '//layouts/page/' . $layout;

        if (!$view = NewsPage::model()->getShowView($model->page->id))
            $view = 'default';

		$this->render($view, array(
            'model'=>$model,
        ));
	}

    protected function loadModel($id)
    {
        if ($this->moduleAllowed('new')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = News::model()->findByPk($id, $condition);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');

        return $model;
    }

}