<?php

namespace app\modules\blog\forms;

use CFormModel;

/**
 * @property integer $word
 */
class SearchForm extends CFormModel
{
    public $word;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'word' => 'Слово',
        ];
    }
}
