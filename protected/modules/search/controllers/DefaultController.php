<?php
/**
 * Created by JetBrains PhpStorm.
 * User: elisdn
 * Date: 7/9/13
 * Time: 10:00 AM
 * To change this template use File | Settings | File Templates.
 */

class DefaultController extends DController
{
    public function actionIndex($q)
    {
        $model = new SearchForm();
        $model->q = $q;

        if ($model->validate())
        {
            $this->createViewTable();

            $criteria = new CDbCriteria();
            $criteria->addSearchCondition('title', $model->q);
            $criteria->addSearchCondition('text', $model->q, true, 'OR');

            $dataProvider = new CActiveDataProvider('Search', array(
                'criteria'=>$criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->config->get('SEARCH.ITEMS_PER_PAGE'),
                    'pageVar' => 'page',
                )
            ));

            $this->render('index', array(
                'dataProvider'=>$dataProvider,
                'query'=>$model->q,
            ));
        }
        else
            $this->render('error');
    }

    private function createViewTable()
    {
        $query = 'CREATE OR REPLACE VIEW {{search}} AS ';
        $tables = array();

        $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.page.models.Page' AS material_import, 'Page' AS material_class FROM {{page}}";
        $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.new.models.News' AS material_import, 'News' AS material_class FROM {{new}} WHERE public=1";

        if (Yii::app()->moduleManager->active('blog'))
            $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.blog.models.BlogPost' AS material_import, 'BlogPost' AS material_class FROM {{blog_post}} WHERE public=1";

        if (Yii::app()->moduleManager->active('portfolio'))
            $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.portfolio.models.PortfolioWork' AS material_import, 'PortfolioWork' AS material_class FROM {{portfolio_work}} WHERE public=1";

        if (Yii::app()->moduleManager->active('recipe'))
            $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.recipe.models.Recipe' AS material_import, 'Recipe' AS material_class FROM {{recipe}}";

        if (Yii::app()->moduleManager->active('rubricator'))
            $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.rubricator.models.RubricatorArticle' AS material_import, 'RubricatorArticle' AS material_class FROM {{rubricator_article}} WHERE public=1";

        if (Yii::app()->moduleManager->active('shop'))
            $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.shop.models.ShopProduct' AS material_import, 'ShopProduct' AS material_class FROM {{shop_product}} WHERE public=1";

        Yii::app()->db->createCommand($query . implode(' UNION ' , $tables))->execute();
    }
}