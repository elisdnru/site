<?php

DUrlRulesHelper::import('contact');

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $phone;
	public $text;
	public $verifyCode;
	public $accept;

	/**
	 * Declares the validation rules.
	 */
   	public function rules()
   	{
   		// NOTE: you should only define rules for those attributes that
   		// will receive user inputs.
   		return array(
   			array('name, email, text, accept', 'required'),
   			array('name', 'length', 'max'=>200),
   			array('email, phone', 'length', 'max'=>100),
            array('email', 'email'),
            array('accept', 'compare', 'compareValue' => '1'),
   			// The following rule is used by search().
   			// Please remove those attributes that should not be searched.
   			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'captchaAction'=>'/contact/default/captcha', 'except'=>'safe'),
   		);
   	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
        return array(
            'name' => 'Ваше имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'text' => 'Сообщение',
            'verifyCode'=>'Проверочный код',
            'accept' => 'Я добровольно отправляю свои данные',
		);
	}
}