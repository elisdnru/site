<?php

namespace app\modules\user\forms;

use yii\base\Model;

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RemindForm extends Model
{
    public $email;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules(): array
    {
        return [
            // username and password are required
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'Введите Email',
        ];
    }
}
