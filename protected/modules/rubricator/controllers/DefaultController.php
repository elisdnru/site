<?php

Yii::import('application.modules.page.models.Page');

class DefaultController extends DController
{
	public function actionIndex()
	{
        $model = $this->loadSearchModel();

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('RUBRICATOR.ITEMS_PER_PAGE'));

        $this->render('index', array(
            'dataProvider'=>$dataProvider,
            'page'=>$this->loadRubricatorPage(),
        ));
	}

	public function actionCategory($category)
	{
        $category = $this->loadCategoryModel($category);

        $model = $this->loadSearchModel();
        $model->category_id = $category->id;

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('RUBRICATOR.ITEMS_PER_PAGE'));

        $this->render('category', array(
            'dataProvider'=>$dataProvider,
            'category'=>$category,
            'page'=>$this->loadRubricatorPage(),
        ));
	}

    protected function loadSearchModel()
    {
        $model = new RubricatorArticle('search');
        $model->unsetAttributes();
        $model->public = 1;
        return $model;
    }

    protected function loadCategoryModel($alias)
    {
        $category = RubricatorCategory::model()->cache(3600 * 24)->findByAlias($alias);
        if ($category === null)
            throw new CHttpException('404', 'Страница не найдена');
        return $category;
    }

    protected function loadRubricatorPage()
    {
        if (!$page = Page::model()->findByAlias('rubricator'))
        {
            $page = new Page;
            $page->title = 'Рубрикатор';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}