<?php

class RecipeModule extends DWebModule
{

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.recipe.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Рецепты';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Рецепты', 'url'=>array('/recipe/recipeAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить рецепт', 'url'=>array('/recipe/recipeAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'recipes'=>'recipe/default/index',
            'recipes/<alias:[\w_-]+>'=>'recipe/recipe/show',
        );
    }
}
