<?php

namespace app\modules\search\controllers;

use app\components\DataProvider;
use app\modules\search\models\Search;
use yii\web\Controller;
use app\modules\search\forms\SearchForm;
use yii\data\ActiveDataProvider;
use yii\db\Connection;
use yii\web\Request;

class DefaultController extends Controller
{
    public function actionIndex(Request $request, Connection $db): string
    {
        $model = new SearchForm();

        if ($model->load($request->getQueryParams()) && $model->validate()) {
            self::createViewTable($db);

            $query = Search::find()
                ->andWhere([
                    'or',
                    ['like', 'title', $model->q],
                    ['like', 'text', $model->q]
                ]);

            $dataProvider = new DataProvider(new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => 10,
                    'forcePageParam' => false,
                ]
            ]));

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'query' => $model->q,
            ]);
        }

        return $this->render('error');
    }

    private static function createViewTable(Connection $db): void
    {
        $query = 'CREATE OR REPLACE VIEW search AS ';
        $tables = [];

        $tables[] = 'SELECT title, text_purified AS text, id AS material_id, \'app\\\\modules\\\\blog\\\\models\\\\Post\' AS material_class FROM blog_posts WHERE public=1';

        $db->createCommand($query . implode(' UNION ', $tables))->execute();
    }
}
