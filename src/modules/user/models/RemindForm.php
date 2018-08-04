<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RemindForm extends CFormModel
{
	public $email;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'emailExists'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Введите Email',
		);
	}

	/**
	 * Check user exists.
	 * This is the 'userExists' validator as declared in rules().
	 */
	public function emailExists($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			if (!$user = User::model()->findByAttributes(array('email'=>$this->email)))
				$this->addError('email','Пользователь с данным Email не найден среди зарегистрированных.');
		}
	}
}
