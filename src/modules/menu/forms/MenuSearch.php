<?php

namespace app\modules\menu\forms;

use app\components\category\TreeActiveDataProvider;
use app\modules\menu\models\Menu;

class MenuSearch extends Menu
{
    public function rules(): array
    {
        return [
            [['id', 'title', 'alias', 'link', 'sort', 'parent_id'], 'safe'],
        ];
    }

    public function search(array $params, $pageSize = 10): TreeActiveDataProvider
    {
        $query = Menu::find()->alias('t');

        $dataProvider = new TreeActiveDataProvider([
            'childrenRelation' => 'children',
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC, 'title' => SORT_ASC],
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
            't.sort'=> $this->sort,
            't.parent_id' => $this->parent_id,
            't.visible' => $this->visible,
        ]);

        $query->andFilterWhere(['like', 't.title', $this->title]);
        $query->andFilterWhere(['like', 't.alias', $this->alias]);
        $query->andFilterWhere(['like', 't.link', $this->link]);

        return $dataProvider;
    }
}
