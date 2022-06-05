<?php

declare(strict_types=1);

namespace app\modules\user\models;

use app\components\Gravatar;
use app\components\uploader\FileUploadBehavior;
use app\modules\comment\models\Comment;
use RuntimeException;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\mail\MailerInterface;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string|null $salt
 * @property string $email
 * @property string|null $identity
 * @property string|null $network
 * @property string|null $confirm
 * @property string $role
 * @property string $create_datetime
 * @property string $last_modify_datetime
 * @property string|null $last_visit_datetime
 * @property int $active
 * @property string|UploadedFile|null $avatar
 * @property string $lastname
 * @property string $firstname
 * @property string|null $site
 */
final class User extends ActiveRecord
{
    public const IMAGE_PATH = 'upload/images/users/avatars';

    public bool $del_avatar = false;

    private ?string $cachedAvatarUrl = null;

    public static function tableName(): string
    {
        return 'users';
    }

    public function getCommentsCount(): int
    {
        return (int)Comment::find()->user($this->id)->published()->count();
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password_hash' => 'Пароль',
            'email' => 'Email',
            'confirm' => 'Ключ подтверждения',
            'role' => 'Роль',
            'create_datetime' => 'Дата регистрации',
            'last_modify_datetime' => 'Последнее изменение',
            'last_visit_datetime' => 'Последнее посещение',
            'active' => 'Активен',
            'avatar' => 'Аватар',

            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'fio' => 'ФИО',
            'site' => 'Сайт',
        ];
    }

    public function behaviors(): array
    {
        return [
            'Timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_datetime',
                'updatedAtAttribute' => 'last_modify_datetime',
                'value' => static fn () => date('Y-m-d H:i:s'),
            ],
            'ImageUpload' => [
                'class' => FileUploadBehavior::class,
                'fileAttribute' => 'avatar',
                'storageAttribute' => 'avatar',
                'deleteAttribute' => 'del_avatar',
                'filePath' => self::IMAGE_PATH,
            ],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if (!$this->role) {
                $this->role = Access::ROLE_USER;
            }

            return true;
        }
        return false;
    }

    public function afterFind(): void
    {
        if ($this->create_datetime === '0000-00-00 00:00:00') {
            $this->create_datetime = '1900-01-01 00:00:00';
        }
        if ($this->last_visit_datetime === '0000-00-00 00:00:00') {
            $this->last_visit_datetime = null;
        }
        parent::afterFind();
    }

    public function validatePassword(string $password): bool
    {
        return
            password_verify($password, $this->password_hash) ||
            password_verify($this->oldHashPassword($password), $this->password_hash);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function oldHashPassword(string $password): string
    {
        return md5('%#w_wrb13&p' . ($this->salt ?: '') . $password);
    }

    public function getFio(): string
    {
        return trim($this->lastname . ' ' . $this->firstname);
    }

    public function getAvatarUrl(int $width = 100, int $height = 100): string
    {
        if ($this->cachedAvatarUrl === null) {
            if (!\is_string($this->avatar)) {
                return $this->getDefaultAvatarUrl($width);
            }
            if (preg_match('|^https?://|', $this->avatar)) {
                $this->cachedAvatarUrl = $this->avatar;
            } elseif ($this->avatar) {
                $this->cachedAvatarUrl =
                    '/' . Yii::$app->uploader->getThumbUrl(self::IMAGE_PATH, $this->avatar, $width, $height);
            } else {
                $this->cachedAvatarUrl = $this->getDefaultAvatarUrl($width);
            }
        }

        return $this->cachedAvatarUrl;
    }

    public function getDefaultAvatarUrl(int $width): string
    {
        return Gravatar::url($this->email, $width);
    }

    public function sendConfirm(MailerInterface $mailer): void
    {
        if (!$this->id) {
            return;
        }

        $this->confirm = md5(microtime());

        $this->updateAttributes(['confirm' => $this->confirm]);

        $mail = $mailer
            ->compose(['html' => '@app/modules/user/views/email/confirm'], ['code' => $this->confirm])
            ->setSubject('Подтверждение регистрации на сайте elisdn.ru')
            ->setTo($this->email);
        if (!$mail->send()) {
            throw new RuntimeException('Unable to send confirm to ' . $this->email);
        }
    }

    public function sendRemind(string $password, MailerInterface $mailer): void
    {
        $mail = $mailer
            ->compose(['html' => '@app/modules/user/views/email/remind'], ['password' => $password])
            ->setSubject('Восстановление пароля на сайте elisdn.ru')
            ->setTo($this->email);
        if (!$mail->send()) {
            throw new RuntimeException('Unable to send remind to ' . $this->email);
        }
    }
}
