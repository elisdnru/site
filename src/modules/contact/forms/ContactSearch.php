<?php

declare(strict_types=1);

namespace app\modules\contact\forms;

use app\modules\contact\models\Contact;
use CActiveDataProvider;
use CDbCriteria;
use yii\data\ActiveDataProvider;

class ContactSearch extends Contact
{
    public function rules(): array
    {
        return [
            [['id', 'pagetitle', 'date', 'name', 'email', 'phone', 'text', 'label', 'status'], 'safe']
        ];
    }

    public function search(array $params, $pageSize = 30): ActiveDataProvider
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['date' => SORT_DESC, 'id' => SORT_DESC],
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
            ->andFilterWhere(['like', 'pagetitle', $this->pagetitle])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
