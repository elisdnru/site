<?php

declare(strict_types=1);

namespace app\modules\page\forms;

use app\components\category\TreeActiveDataProvider;
use app\components\DataProvider;
use app\modules\page\models\Page;
use yii\base\Model;

final class PageSearch extends Model
{
    public ?string $id = null;
    public ?string $title = null;
    public ?string $alias = null;
    public ?string $text = null;
    public ?string $parent_id = null;
    public ?string $system = null;

    public function rules(): array
    {
        return [
            [['id', 'title', 'alias', 'text', 'parent_id', 'system'], 'safe'],
        ];
    }

    public function search(array $params, int $pageSize = 100): DataProvider
    {
        $query = Page::find()->alias('t');

        $dataProvider = new DataProvider(new TreeActiveDataProvider([
            'childrenRelation' => 'children',
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
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
            't.parent_id' => $this->parent_id,
            't.system' => $this->system,
        ]);

        $query->andFilterWhere(['like', 't.title', $this->title]);
        $query->andFilterWhere(['like', 't.alias', $this->alias]);
        $query->andFilterWhere(['like', 't.text', $this->text]);

        return $dataProvider;
    }
}
