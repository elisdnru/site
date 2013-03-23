<?php

Yii::import('application.modules.page.models.Page');

class ArticleController extends DController
{
    public function actionShow($id)
	{
		$model = $this->loadModel($id);

		$this->render('show', array(
            'model'=>$model,
            'page'=>$this->loadRubrikatorPage(),
        ));
	}

    protected function loadModel($id)
    {
        $model = RubrikatorArticle::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }

    protected function loadRubrikatorPage()
    {
        if (!$page = Page::model()->findByAlias('rubrikator'))
        {
            $page = new Page();
            $page->title = 'Рубрикатор';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}