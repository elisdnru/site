<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use app\components\ImageValidator;
use app\modules\user\models\User;
use yii\base\Model;
use yii\web\UploadedFile;

final class ProfileForm extends Model
{
    public string $lastname = '';
    public string $firstname = '';
    public ?string $site = null;
    public ?UploadedFile $avatar = null;
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
            // TODO: remove checkExtensionByMimeType after https://github.com/yiisoft/yii2/pull/19246 release
            ['avatar', ImageValidator::class, 'checkExtensionByMimeType' => false],
            ['del_avatar', 'safe'],
        ];
    }

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
