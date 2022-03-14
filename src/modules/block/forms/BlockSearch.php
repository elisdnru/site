<?php

declare(strict_types=1);

namespace app\modules\block\forms;

use app\components\DataProvider;
use app\modules\block\models\Block;
use yii\base\Model;
use yii\data\ActiveDataProvider;

final class BlockSearch extends Model
{
    public ?string $id = null;
    public ?string $alias = null;
    public ?string $title = null;
    public ?string $text = null;

    public function rules(): array
    {
        return [
            [['id', 'alias', 'title', 'text'], 'safe'],
        ];
    }

    public function search(array $params, int $pageSize = 30): DataProvider
    {
        $query = Block::find();

        $dataProvider = new DataProvider(new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
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
        ]);

        $query
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
