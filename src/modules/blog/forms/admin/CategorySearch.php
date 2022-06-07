<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\components\category\TreeActiveDataProvider;
use app\components\DataProvider;
use app\modules\blog\models\Category;
use yii\base\Model;

final class CategorySearch extends Model
{
    public ?string $id = null;
    public ?string $title = null;
    public ?string $slug = null;
    public ?string $link = null;
    public ?string $sort = null;
    public ?string $parent_id = null;

    public function rules(): array
    {
        return [
            [['id', 'title', 'slug', 'link', 'sort', 'parent_id'], 'safe'],
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
            't.sort' => $this->sort,
            't.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 't.title', $this->title]);
        $query->andFilterWhere(['like', 't.slug', $this->slug]);

        return $dataProvider;
    }
}
