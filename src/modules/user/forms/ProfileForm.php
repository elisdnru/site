<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use app\components\ImageValidator;
use app\modules\user\models\User;
use Override;
use yii\base\Model;
use yii\web\UploadedFile;

final class ProfileForm extends Model
{
    public string $lastname = '';
    public string $firstname = '';
    public ?string $site = null;
    public ?UploadedFile $avatar = null;
    public string $del_avatar = '';

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);

        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->site = $user->site;
    }

    #[Override]
    public function rules(): array
    {
        return [
            [['lastname', 'firstname'], 'required'],
            [['lastname', 'firstname'], 'string', 'max' => 255],
            ['site', 'url'],
            ['avatar', ImageValidator::class],
            ['del_avatar', 'safe'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'site' => 'Сайт',
            'avatar' => 'Аватар',
            'del_avatar' => 'Сбросить аватар',
        ];
    }
}
