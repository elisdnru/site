<?php

Yii::import('application.modules.page.models.Page');

class DefaultController extends DController
{
	public function actionIndex()
	{
        $model = $this->loadSearchModel();

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('GENERAL.NEWS_PER_PAGE'));

        $this->render('index', array(
            'dataProvider'=>$dataProvider,
            'page'=>$this->loadRubrikatorPage(),
        ));
	}

	public function actionCategory($category)
	{
        $category = $this->loadCategoryModel($category);

        $model = $this->loadSearchModel();
        $model->category_id = $category->id;

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('GENERAL.NEWS_PER_PAGE'));

        $this->render('category', array(
            'dataProvider'=>$dataProvider,
            'category'=>$category,
            'page'=>$this->loadRubrikatorPage(),
        ));
	}

    protected function loadSearchModel()
    {
        $model = new RubrikatorArticle('search');
        $model->unsetAttributes();
        $model->public = 1;
        return $model;
    }

    protected function loadCategoryModel($alias)
    {
        $category = RubrikatorCategory::model()->cache(3600 * 24)->findByAlias($alias);
        if ($category === null)
            throw new CHttpException('404', 'Страница не найдена');
        return $category;
    }

    protected function loadRubrikatorPage()
    {
        if (!$page = Page::model()->findByAlias('rubrikator'))
        {
            $page = new Page;
            $page->title = 'Рубрикатор';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}