<?php
/**
 * Created by JetBrains PhpStorm.
 * User: elisdn
 * Date: 7/9/13
 * Time: 10:00 AM
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\search\controllers;

use app\modules\search\models\Search;
use app\components\Controller;
use app\modules\search\forms\SearchForm;
use Yii;
use yii\data\ActiveDataProvider;

class DefaultController extends Controller
{
    public function actionIndex($q): void
    {
        $model = new SearchForm();
        $model->q = $q;

        if ($model->validate()) {
            $this->createViewTable();

            $query = Search::find()
                ->andWhere([
                    'or',
                    ['like', 'title', $model->q],
                    ['like', 'text', $model->q]
                ]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
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

    private function createViewTable(): void
    {
        $query = 'CREATE OR REPLACE VIEW search AS ';
        $tables = [];

        $tables[] = 'SELECT title, text_purified AS text, id AS material_id, \'app\\\\modules\\\\page\\\\models\\\\Page\' AS material_class FROM pages';
        $tables[] = 'SELECT title, text, id AS material_id, \'app\\\\modules\\\\landing\\\\models\\\\Landing\' AS material_class FROM landings';
        $tables[] = 'SELECT title, text_purified AS text, id AS material_id, \'app\\\\modules\\\\blog\\\\models\\\\Post\' AS material_class FROM blog_posts WHERE public=1';
        $tables[] = 'SELECT title, text_purified AS text, id AS material_id, \'app\\\\modules\\\\portfolio\\\\models\\\\Work\' AS material_class FROM portfolio_works WHERE public=1';

        Yii::$app->db->createCommand($query . implode(' UNION ', $tables))->execute();
    }
}
