<?php

/**
 * @property integer $word
 */
class ShopSearchForm extends CFormModel
{
    public $word;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('word', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'word' => 'Слово',
        );
    }

}