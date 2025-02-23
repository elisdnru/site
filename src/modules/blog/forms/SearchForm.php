<?php

declare(strict_types=1);

namespace app\modules\blog\forms;

use Override;
use yii\base\Model;

final class SearchForm extends Model
{
    public ?string $q = null;

    #[Override]
    public function rules(): array
    {
        return [
            ['q', 'required'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'q' => 'Слово',
        ];
    }

    #[Override]
    public function formName(): string
    {
        return '';
    }
}
