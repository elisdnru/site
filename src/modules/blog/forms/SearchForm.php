<?php

namespace app\modules\blog\forms;

use yii\base\Model;

/**
 * @property integer $word
 */
class SearchForm extends Model
{
    public ?string $word = null;

    public function rules(): array
    {
        return [
            ['word', 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'word' => 'Слово',
        ];
    }

    public function formName(): string
    {
        return '';
    }
}
