<?php

declare(strict_types=1);

namespace app\modules\user\forms\admin;

use app\components\ImageValidator;
use app\modules\user\components\UsernameValidator;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use yii\base\Model;
use yii\web\UploadedFile;

class EditForm extends Model
{
    public int $id = 0;
    public string $username = '';
    public string $email = '';
    public string $lastname = '';
    public string $firstname = '';
    public ?string $site = null;
    public ?UploadedFile $avatar = null;
    public string $del_avatar = '';
    public string $role = '';

    public static function fromUser(User $user): self
    {
        $form = new self();
        $form->id = $user->id;
        $form->username = $user->username;
        $form->email = $user->email;
        $form->firstname = $user->firstname;
        $form->lastname = $user->lastname;
        $form->site = $user->site;
        $form->role = $user->role;
        return $form;
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'lastname', 'firstname', 'role'], 'required'],
            [['username', 'email', 'lastname', 'firstname'], 'string', 'max' => 255],
            ['username', UsernameValidator::class],
            [
                'username',
                'unique',
                'message' => 'Такой {attribute} уже используется',
                'targetClass' => User::class,
                'filter' => ['!=', 'id', $this->id],
            ],
            ['email', 'email', 'message' => 'Неверный формат E-mail адреса'],
            [
                'email',
                'unique',
                'message' => 'Такой {attribute} уже используется',
                'targetClass' => User::class,
                'filter' => ['!=', 'id', $this->id],
            ],
            ['site', 'url'],
            ['avatar', ImageValidator::class],
            ['del_avatar', 'safe'],
            ['role', 'in', 'range' => array_keys(Access::getRoles())],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'site' => 'Сайт',
            'avatar' => 'Аватар',
            'del_avatar' => 'Сбросить аватар',
            'role' => 'Роль',
        ];
    }

    public function getRoles(): array
    {
        return Access::getRoles();
    }
}
