<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use yii\base\Model;

class ProfileForm extends Model
{
    public string $lastname = '';
    public string $firstname = '';
    public string $site = '';
    public string $avatar = '';
    public string $del_avatar = '';

    public static function fromUser(User $user): self
    {
        $form = new self();
        $form->firstname = $user->firstname;
        $form->lastname = $user->lastname;
        $form->site = $user->site;
        return $form;
    }

    public function rules(): array
    {
        return [
            [['lastname', 'firstname'], 'required'],
            [['lastname', 'firstname'], 'string', 'max' => 255],
            ['site', 'url'],
            ['del_avatar', 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'site' => 'Сайт',
        ];
    }
}
