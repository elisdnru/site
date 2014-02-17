<?php

Yii::import('application.modules.page.models.Page');

class RecipeController extends DController
{
    public function actionShow($alias)
	{
		$recipe = $this->loadModel($alias);

		$this->render('show', array(
            'recipe'=>$recipe,
            'page'=>$this->loadRecipePage(),
        ));
	}

    protected function loadModel($alias)
    {
        $model = Recipe::model()->findByAlias($alias);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }

    protected function loadRecipePage()
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath('recipes');
        if (!$page)
        {
            $page = new Page;
            $page->title = 'Рецепты';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}