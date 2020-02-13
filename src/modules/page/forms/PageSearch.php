<?php

declare(strict_types=1);

namespace app\modules\page\forms;

use app\components\category\TreeActiveDataProvider;
use app\modules\page\models\Page;

class PageSearch extends Page
{
    public function rules(): array
    {
        return [
            [['id', 'title', 'alias', 'text', 'parent_id', 'system'], 'safe'],
        ];
    }

    public function search(array $params, $pageSize = 100): TreeActiveDataProvider
    {
        $query = Page::find()->alias('t');

        $dataProvider = new TreeActiveDataProvider([
            'childrenRelation' => 'children',
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageParam' => 'page',
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            't.id' => $this->id,
            't.parent_id' => $this->parent_id,
            't.system' => $this->system,
        ]);

        $query->andFilterWhere(['like', 't.title', $this->title]);
        $query->andFilterWhere(['like', 't.alias', $this->alias]);
        $query->andFilterWhere(['like', 't.text', $this->text]);

        return $dataProvider;
    }
}
