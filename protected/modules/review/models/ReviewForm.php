<?php

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $name
 * @property string $text
 * @property string $verifyCode
 */
class ReviewForm extends CFormModel
{
    public $name;
    public $email;
    public $text;
    public $verifyCode;

    /*
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, text', 'required'),
            array(' name, email', 'length', 'max'=>'255'),
            array('email', 'email', 'message' => 'Неверный формат E-mail адреса'),
            array('text', 'safe'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Автор',
			'text' => 'Текст',
			'verifyCode' => 'Проверочный код',
		);
	}
}