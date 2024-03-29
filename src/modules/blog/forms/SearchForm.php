<?php

declare(strict_types=1);

namespace app\modules\blog\forms;

use yii\base\Model;

final class SearchForm extends Model
{
    public ?string $q = null;

    public function rules(): array
    {
        return [
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
