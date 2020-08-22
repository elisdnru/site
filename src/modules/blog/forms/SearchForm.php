<?php

namespace app\modules\blog\forms;

use yii\base\Model;

/**
 * @property integer $word
 */
class SearchForm extends Model
{
    public ?string $word = null;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['word', 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
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
