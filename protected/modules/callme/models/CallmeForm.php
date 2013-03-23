<?php

DUrlRulesHelper::import('callme');

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class CallmeForm extends CFormModel
{
	public $name;
	public $tel;
	public $text;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
   	public function rules()
   	{
   		// NOTE: you should only define rules for those attributes that
   		// will receive user inputs.
   		return array(
   			array('tel', 'required'),
   			array('name', 'length', 'max'=>200),
   			array('tel', 'length', 'max'=>100),
            array('text', 'safe'),
   			// The following rule is used by search().
   			// Please remove those attributes that should not be searched.
   			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'captchaAction'=>'/callme/default/captcha', 'except'=>'safe'),
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
            'tel' => 'Телефон',
            'text' => 'Когда позвонить',
            'verifyCode'=>'Проверочный код',
		);
	}
}