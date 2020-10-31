<?php

namespace app\modules\user\models;

use app\components\Gravatar;
use app\components\uploader\FileUploadBehavior;
use app\modules\comment\models\Comment;
use RuntimeException;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $salt
 * @property string $email
 * @property string $identity
 * @property string $network
 * @property string $confirm
 * @property string $role
 * @property string $create_datetime
 * @property string $last_modify_datetime
 * @property string|null $last_visit_datetime
 * @property integer $active
 * @property string|UploadedFile $avatar
 *
 * @property string $lastname
 * @property string $firstname
 * @property string $site
 */
class User extends ActiveRecord
{
    public const IMAGE_PATH = 'upload/images/users/avatars';
    public const IMAGE_WIDTH = 100;
    public const IMAGE_HEIGHT = 100;

    public bool $del_avatar = false;

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
                'value' => static function () {
                    return new Expression('NOW()');
                },
            ],
            'ImageUpload' => [
                'class' => FileUploadBehavior::class,
                'fileAttribute' => 'avatar',
                'deleteAttribute' => 'del_avatar',
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
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

    public function validatePassword($password): bool
    {
        return
            password_verify($password, $this->password_hash) ||
            password_verify($this->oldHashPassword($password), $this->password_hash);
    }

    public function hashPassword(string $password): string
    {
        return (string)password_hash($password, PASSWORD_DEFAULT);
    }

    public function oldHashPassword($password): string
    {
        return md5('%#w_wrb13&p' . $this->salt . $password);
    }

    public function getFio(): ?string
    {
        return trim($this->lastname . ' ' . $this->firstname);
    }

    private ?string $cachedAvatarUrl = null;

    public function getAvatarUrl($width = self::IMAGE_WIDTH, $height = self::IMAGE_HEIGHT): string
    {
        if ($this->cachedAvatarUrl === null) {
            if (!is_string($this->avatar)) {
                return '';
            }
            if (preg_match('|^https?:\/\/|', $this->avatar)) {
                $this->cachedAvatarUrl = $this->avatar;
            } elseif ($this->avatar) {
                $this->cachedAvatarUrl = '/' . Yii::$app->uploader->getThumbUrl(self::IMAGE_PATH, $this->avatar, $width, $height);
            } else {
                $this->cachedAvatarUrl = $this->getDefaultAvatarUrl($width);
            }
        }

        return $this->cachedAvatarUrl;
    }

    public function getDefaultAvatarUrl($width): string
    {
        return Gravatar::url($this->email, $width, Yii::$app->request->hostInfo . '/images/noavatar.png');
    }

    public function sendCommit(): void
    {
        if (!$this->id) {
            return;
        }

        $this->confirm = md5(microtime());

        $this->updateAttributes(['confirm' => $this->confirm]);

        $mail = Yii::$app->mailer
            ->compose(['html' => 'confirm'], [
                'user' => $this,
                'confirmUrl' => Url::to(['/user/registration/confirm', 'code' => $this->confirm], true),
            ])
            ->setSubject('Подтверждение регистрации на сайте elisdn.ru')
            ->setTo($this->email);
        if (!$mail->send()) {
            throw new RuntimeException('Unable to send confirm to ' . $this->email);
        }
    }

    public function sendRemind(string $password): void
    {
        $mail = Yii::$app->mailer
            ->compose(['html' => 'remind'], [
                'password' => $password,
            ])
            ->setSubject('Восстановление пароля на сайте elisdn.ru')
            ->setTo($this->email);
        if (!$mail->send()) {
            throw new RuntimeException('Unable to send remind to ' . $this->email);
        }
    }
}
