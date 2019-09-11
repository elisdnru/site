<?php
/**
 * Created by JetBrains PhpStorm.
 * User: elisdn
 * Date: 7/9/13
 * Time: 10:00 AM
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\search\controllers;

use CActiveDataProvider;
use CDbCriteria;
use DController;
use SearchForm;
use Yii;

class DefaultController extends DController
{
    public function actionIndex($q)
    {
        $model = new SearchForm();
        $model->q = $q;

        if ($model->validate()) {
            $this->createViewTable();

            $criteria = new CDbCriteria();
            $criteria->addSearchCondition('title', $model->q);
            $criteria->addSearchCondition('text', $model->q, true, 'OR');

            $dataProvider = new CActiveDataProvider('Search', [
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => 10,
                    'pageVar' => 'page',
                ]
            ]);

            $this->render('index', [
                'dataProvider' => $dataProvider,
                'query' => $model->q,
            ]);
        } else {
            $this->render('error');
        }
    }

    private function createViewTable()
    {
        $query = 'CREATE OR REPLACE VIEW {{search}} AS ';
        $tables = [];

        $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.page.models.Page' AS material_import, 'Page' AS material_class FROM {{page}}";
        $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.blog.models.BlogPost' AS material_import, 'BlogPost' AS material_class FROM {{blog_post}} WHERE public=1";
        $tables[] = "SELECT title, text_purified AS text, id AS material_id, 'application.modules.portfolio.models.PortfolioWork' AS material_import, 'PortfolioWork' AS material_class FROM {{portfolio_work}} WHERE public=1";

        Yii::app()->db->createCommand($query . implode(' UNION ', $tables))->execute();
    }
}
