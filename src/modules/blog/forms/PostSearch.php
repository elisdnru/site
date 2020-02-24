<?php

declare(strict_types=1);

namespace app\modules\blog\forms;

use app\modules\blog\models\Post;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{
    public function rules(): array
    {
        return [
            [['id', 'date', 'category_id', 'author_id', 'title'], 'safe'],
            [['pagetitle', 'description', 'image_alt', 'text', 'public'], 'safe'],
        ];
    }

    public function search(array $params, $pageSize = 30): ActiveDataProvider
    {
        $query = self::find()->alias('t')->joinWith(['category', 'group']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['t.date' => SORT_DESC],
                'attributes' => [
                    't.date',
                    't.update_date',
                    't.title',
                    't.category_id' => [
                        'asc' => ['category.title' => SORT_ASC],
                        'desc' => ['category.title' => SORT_DESC],
                    ],
                    't.author_id' => [
                        'asc' => ['author.username' => SORT_ASC],
                        'desc' => ['author.username' => SORT_DESC],
                    ],
                    't.group_id' => [
                        'asc' => ['group.title' => SORT_ASC],
                        'desc' => ['group.title' => SORT_DESC],
                    ],
                    't.public',
                ]
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'author_id' => $this->author_id,
            'group_id' => $this->group_id,
            'public' => $this->public,
        ]);

        $query
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'update_date', $this->update_date]);

        return $dataProvider;
    }
}
