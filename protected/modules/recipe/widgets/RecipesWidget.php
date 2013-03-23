<?php

Yii::import('recipe.models.Recipe');
DUrlRulesHelper::import('recipe');

class RecipesWidget extends DWidget
{
    public $tpl = 'default';
	public $limit = 6;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        $criteria->limit = $this->limit;
        $criteria->order = 'date DESC';

        $recipes = Recipe::model()->findAll($criteria);

		$this->render('Recipes/'.$this->tpl ,array(
            'recipes'=>$recipes,
        ));
	}
}