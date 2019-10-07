<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use CFormModel;

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
        return [
            // username and password are required
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'emailExists'],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Введите Email',
        ];
    }

    /**
     * Check user exists.
     * This is the 'userExists' validator as declared in rules().
     */
    public function emailExists()
    {
        if (!$this->hasErrors()) {
            if (!$user = User::model()->findByAttributes(['email' => $this->email])) {
                $this->addError('email', 'Пользователь с данным Email не найден среди зарегистрированных.');
            }
        }
    }
}
