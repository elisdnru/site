<?php

declare(strict_types=1);

namespace app\modules\user\forms\admin;

use app\components\ImageValidator;
use app\modules\user\components\UsernameValidator;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use yii\base\Model;
use yii\web\UploadedFile;

final class EditForm extends Model
{
    public int $id = 0;
    public string $username = '';
    public string $email = '';
    public string $lastname = '';
    public string $firstname = '';
    public ?string $site = null;
    public UploadedFile|string|null $avatar = null;
    public string $del_avatar = '';
    public string $role = '';

    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);

        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->site = $user->site;
        $this->role = $user->role;
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
