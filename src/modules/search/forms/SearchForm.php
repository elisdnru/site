<?php

namespace app\modules\search\forms;

use yii\base\Model;

/**
 * @property integer $word
 */
class SearchForm extends Model
{
    public $q;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['q', 'filter', 'filter' => 'trim'],
            ['q', 'required'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
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
