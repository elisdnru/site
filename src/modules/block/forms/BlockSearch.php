<?php

declare(strict_types=1);

namespace app\modules\block\forms;

use app\modules\block\models\Block;
use yii\data\ActiveDataProvider;

class BlockSearch extends Block
{
    public function rules(): array
    {
        return [
            [['id', 'alias', 'title', 'text'], 'safe'],
        ];
    }

    public function search(array $params, $pageSize = 30): ActiveDataProvider
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            //$query->where('0=1');
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
