<?php

declare(strict_types=1);

namespace app\modules\landing\forms;

use app\components\category\TreeActiveDataProviderV2;
use app\modules\landing\models\Landing;

class LandingSearch extends Landing
{
    public function rules(): array
    {
        return [
            [['id', 'title', 'alias', 'text', 'parent_id', 'system'], 'safe'],
        ];
    }

    public function search(array $params, $pageSize = 100): TreeActiveDataProviderV2
    {
        $query = Landing::find()->alias('t');

        $dataProvider = new TreeActiveDataProviderV2([
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