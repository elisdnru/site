<?php

Yii::import('application.modules.page.models.Page');

class ArticleController extends DController
{
    public function actionShow($id)
	{
		$model = $this->loadModel($id);

		$this->render('show', array(
            'model'=>$model,
            'page'=>$this->loadRubricatorPage(),
        ));
	}

    protected function loadModel($id)
    {
        $model = RubricatorArticle::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }

    protected function loadRubricatorPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('rubricator'))
        {
            $page = new Page;
            $page->title = 'Рубрикатор';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}