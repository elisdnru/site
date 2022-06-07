<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\components\DataProvider;
use app\modules\blog\models\Post;
use yii\base\Model;
use yii\data\ActiveDataProvider;

final class PostSearch extends Model
{
    public ?string $id = null;
    public ?string $date = null;
    public ?string $update_date = null;
    public ?string $category_id = null;
    public ?string $group_id = null;
    public ?string $author_id = null;
    public ?string $title = null;
    public ?string $slug = null;
    public ?string $public = null;

    public function rules(): array
    {
        return [
            [['id', 'date', 'update_date', 'category_id', 'group_id', 'author_id', 'title', 'slug'], 'safe'],
            [['meta_title', 'meta_description', 'image_alt', 'text', 'public'], 'safe'],
        ];
    }

    public function search(array $params, int $pageSize = 30): DataProvider
    {
        $query = Post::find()->alias('t')->joinWith(['category', 'group']);

        $dataProvider = new DataProvider(new ActiveDataProvider([
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
                ],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]));

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
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'update_date', $this->update_date]);

        return $dataProvider;
    }
}
