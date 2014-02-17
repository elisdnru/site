<?php

Yii::import('application.modules.page.models.Page');

class DefaultController extends DController
{
	public function actionIndex()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        $count = Recipe::model()->cache(0, new Tags('recipe'))->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = Yii::app()->config->get('NEW.NEWS_PER_PAGE');
        $pages->applyLimit($criteria);

        $criteria->order = 't.date DESC';
        $recipes = Recipe::model()->cache(0, new Tags('recipe'))->findAll($criteria);

        $this->render('index', array(
            'page'=>$this->loadRecipePage(),
            'recipes'=>$recipes,
            'pages'=>$pages,
        ));
	}

    protected function loadRecipePage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('recipes'))
        {
            $page = new Page;
            $page->title = 'Рецепты';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}