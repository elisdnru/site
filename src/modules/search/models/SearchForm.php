<?php

/**
 * @property integer $word
 */
class SearchForm extends CFormModel
{
    public $q;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('q', 'filter', 'filter'=>'trim'),
            array('q', 'required'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'q' => 'Слово',
        );
    }

}