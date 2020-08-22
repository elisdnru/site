<?php

namespace app\modules\search\forms;

use yii\base\Model;

class SearchForm extends Model
{
    public $q;

    public function rules(): array
    {
        return [
            ['q', 'filter', 'filter' => 'trim'],
            ['q', 'required'],
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
