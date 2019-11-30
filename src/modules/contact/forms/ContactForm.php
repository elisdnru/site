<?php

namespace app\modules\contact\forms;

use yii\base\Model;

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $text;
    public $test;
    public $accept;

    /**
     * Declares the validation rules.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['name', 'email', 'text', 'accept'], 'required'],
            ['name', 'string', 'max' => 200],
            [['email', 'phone'], 'string', 'max' => 100],
            ['email', 'email'],
            ['accept', 'compare', 'compareValue' => '1'],
            ['test', 'captcha', 'captchaAction' => '/contact/default/captcha'],
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'text' => 'Сообщение',
            'test' => 'Проверочный код',
            'accept' => 'Я добровольно отправляю свои данные',
        ];
    }
}
