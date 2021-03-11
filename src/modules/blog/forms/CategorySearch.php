<?php

namespace app\modules\blog\forms;

use app\components\category\TreeActiveDataProvider;
use app\components\DataProvider;
use app\modules\blog\models\Category;

class CategorySearch extends Category
{
    public function rules(): array
    {
        return [
            [['id', 'title', 'alias', 'link', 'sort', 'parent_id'], 'safe'],
        ];
    }

    public function search(array $params, int $pageSize = 10): DataProvider
    {
        $query = Category::find()->alias('t');

        $dataProvider = new DataProvider(new TreeActiveDataProvider([
            'childrenRelation' => 'children',
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC, 'title' => SORT_ASC],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageParam' => 'page',
            ],
        ]));

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            't.id' => $this->id,
            't.sort'=> $this->sort,
            't.parent_id' => $this->parent_id
        ]);

        $query->andFilterWhere(['like', 't.title', $this->title]);
        $query->andFilterWhere(['like', 't.alias', $this->alias]);

        return $dataProvider;
    }
}
