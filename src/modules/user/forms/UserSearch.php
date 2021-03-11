<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use app\components\DataProvider;
use app\modules\user\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class UserSearch extends User
{
    public ?string $fio = null;

    public function rules(): array
    {
        return [
            [['id', 'username', 'email', 'create_datetime', 'last_modify_datetime', 'last_visit_datetime', 'active', 'identity', 'network', 'lastname', 'firstname', 'role'], 'safe'],
        ];
    }

    public function search(array $params, int $pageSize = 30): DataProvider
    {
        $query = self::find();

        $dataProvider = new DataProvider(new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id',
                    'username',
                    'email',
                    'fio' => [
                        'asc' => ['lastname' => SORT_ASC, 'firstname' => SORT_ASC,],
                        'desc' => ['lastname' => SORT_DESC, 'firstname' => SORT_DESC],
                    ],
                    'role',
                    'create_datetime' => [
                        'asc' => ['create_datetime' => SORT_ASC],
                        'desc' => ['create_datetime' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]));

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'role' => $this->role,
        ]);

        $query
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'create_datetime', $this->create_datetime]);

        if (!empty($this->fio)) {
            $query->andWhere(['like', new Expression('CONCAT(lastname, \' \', firstname)'), $this->fio]);
        }

        return $dataProvider;
    }
}
