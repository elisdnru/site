<?php

namespace app\modules\blog\forms;

use yii\base\Model;

class SearchForm extends Model
{
    public ?string $q = null;

    public function rules(): array
    {
        return [
            ['q', 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'q' => 'Слово',
        ];
    }

    public function formName(): string
    {
        return '';
    }
}
