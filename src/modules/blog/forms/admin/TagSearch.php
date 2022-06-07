<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\components\DataProvider;
use app\modules\blog\models\Tag;
use yii\base\Model;
use yii\data\ActiveDataProvider;

final class TagSearch extends Model
{
    public ?string $id = null;
    public ?string $title = null;

    public function rules(): array
    {
        return [
            [['id', 'title'], 'safe'],
        ];
    }

    public function search(array $params, int $pageSize = 100): DataProvider
    {
        $query = Tag::find();

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
            't.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 't.title', $this->title]);

        return $dataProvider;
    }
}
