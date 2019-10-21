<?php

namespace app\modules\user\models;

use app\components\helpers\GravatarHelper;
use app\components\validators\CaptchaValidator;
use app\modules\comment\models\Comment;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $new_password
 * @property string $new_confirm
 * @property string $old_password
 * @property string $email
 * @property string $identity
 * @property string $network
 * @property string $confirm
 * @property string $role
 * @property string $create_datetime
 * @property string $last_modify_datetime
 * @property string $last_visit_datetime
 * @property integer $active
 * @property string $avatar
 *
 * @property string $lastname
 * @property string $name
 * @property string $middlename
 * @property string $site
 *
 * @property int $comments_count
 * @property int comments_count_real
 * @property string $fio
 */
class User extends ActiveRecord
{
    public const SCENARIO_REGISTER = 'register';
    public const SCENARIO_SETTINGS = 'settings';
    public const SCENARIO_ADMIN_CREATE = 'admin_create';
    public const SCENARIO_ADMIN_UPDATE = 'admin_update';
    public const SCENARIO_SEARCH = 'search';

    public const IMAGE_PATH = 'upload/images/users/avatars';
    public const IMAGE_WIDTH = 100;
    public const IMAGE_HEIGHT = 100;

    public $new_password;
    public $new_confirm;
    public $old_password;
    public $del_avatar = false;

    public $verifyCode;

    public static function tableName(): string
    {
        return 'users';
    }

    public function rules(): array
    {
        return [

            // Login
            [
                'username',
                'required',
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],
            [
                'username',
                'string',
                'max' => 255,
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],
            [
                'username',
                'match',
                'pattern' => '#^[a-zA-Z0-9_\.-]+$#',
                'message' => 'Логин содержит запрещённые символы',
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],
            [
                'username',
                'unique',
                'message' => 'Такой {attribute} уже используется',
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],

            // Email
            [
                'email',
                'required',
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],
            [
                'email',
                'email',
                'message' => 'Неверный формат E-mail адреса',
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],
            [
                'email',
                'string',
                'max' => 255,
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],
            [
                'email',
                'unique',
                'message' => 'Такой {attribute} уже используется',
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],

            // Password
            [
                'new_password',
                'required',
                'on' => [
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                ]
            ],
            [
                'new_password',
                'string',
                'min' => 6,
                'max' => 255,
            ],
            [
                'new_password',
                'filter',
                'filter' => 'trim'
            ],

            [
                'new_confirm',
                'compare',
                'compareAttribute' => 'new_password',
                'message' => 'Пароли не совпадают'
            ],

            [
                'old_password',
                \app\modules\user\components\CurrentPasswordValidator::class,
                'className' => self::class,
                'validateMethod' => 'validatePassword',
                'dependsOnAttributes' => ['new_password'],
                'on' => ['settings']
            ],

            // Login
            [
                'role',
                'required',
                'on' => [
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],

            // Active
            [
                'active',
                'integer',
                'integerOnly' => true,
                'on' => [
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                ]
            ],

            // Avatar
            [
                'del_avatar',
                'safe'
            ],

            // Name
            [
                ['lastname', 'name'],
                'required'
            ],
            [
                ['lastname', 'name', 'middlename'],
                'string',
                'max' => 255
            ],

            // Site
            [
                'site',
                'url'
            ],
            [
                'site',
                'string',
                'max' => 255
            ],

            [
                'verifyCode',
                CaptchaValidator::class,
                'allowEmpty' => !Yii::app()->user->isGuest,
                'message' => 'Код подтверждения введён неверно',
                'captchaAction' => '/user/default/captcha',
                'on' => [
                    self::SCENARIO_REGISTER
                ],
            ],
        ];
    }

    public function getCommentsCountReal()
    {
        return Comment::model()->user($this->id)->count('public=1');
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'new_password' => 'Новый пароль',
            'new_confirm' => 'Подтверждение пароля',
            'old_password' => 'Текущий пароль',
            'email' => 'Email',
            'confirm' => 'Ключ подтверждения',
            'role' => 'Роль',
            'create_datetime' => 'Дата регистрации',
            'last_modify_datetime' => 'Последнее изменение',
            'last_visit_datetime' => 'Последнее посещение',
            'active' => 'Активен',
            'avatar' => 'Аватар',
            'del_avatar' => 'Сбросить аватар',
            'verifyCode' => 'Проверочный код',

            'name' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'fio' => 'ФИО',
            'site' => 'Сайт',
        ];
    }

    public function behaviors(): array
    {
        return [
            'CTimestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_datetime',
                'updatedAtAttribute' => 'last_modify_datetime',
                'value' => static function () {
                    return new Expression('NOW()');
                },
            ],
            'ImageUpload' => [
                'class' => \app\components\uploader\v2\FileUploadBehavior::class,
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
            if ($this->new_password) {
                $this->password = $this->hashPassword($this->new_password);
            }

            if (!$this->role) {
                $this->role = Access::ROLE_USER;
            }

            $this->updateCommentsCount();
            return true;
        }
        return false;
    }

    public function validatePassword($password): bool
    {
        return
            password_verify($password, $this->password) ||
            password_verify($this->oldHashPassword($password), $this->password);
    }

    public function hashPassword($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function oldHashPassword($password): string
    {
        return md5('%#w_wrb13&p' . $this->salt . $password);
    }

    private $_fio;

    public function getFio(): ?string
    {
        if ($this->_fio === null) {
            $this->_fio = trim($this->lastname . ' ' . $this->name . ' ' . $this->middlename);
            if (!$this->_fio) {
                $this->_fio = $this->username;
            }
        }
        return $this->_fio;
    }

    public function setFio($value): void
    {
        $this->_fio = $value;
    }

    private $_avatarUrl;

    public function getAvatarUrl($width = self::IMAGE_WIDTH, $height = self::IMAGE_HEIGHT): string
    {
        if ($this->_avatarUrl === null) {
            if (preg_match('|^https?:\/\/|', $this->avatar)) {
                $this->_avatarUrl = $this->avatar;
            } elseif ($this->avatar) {
                $this->_avatarUrl = '/' . Yii::$app->uploader->getThumbUrl(self::IMAGE_PATH, $this->avatar, $width, $height);
            } else {
                $this->_avatarUrl = $this->getDefaultAvatarUrl($width);
            }
        }

        return $this->_avatarUrl;
    }

    public function getDefaultAvatarUrl($width)
    {
        return GravatarHelper::get($this->email, $width, Yii::app()->request->hostInfo . '/images/noavatar.png');
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
                'confirmUrl' => Yii::app()->createAbsoluteUrl('/user/default/confirm', ['code' => $this->confirm]),
            ])
            ->setSubject('Подтверждение регистрации на сайте elisdn.ru')
            ->setTo($this->email);
        if (!$mail->send()) {
            throw new \RuntimeException('Unable to send confirm to ' . $this->email);
        }
    }

    public function sendRemind(): void
    {
        $mail = Yii::$app->mailer
            ->compose(['html' => 'remind'], [
                'user' => $this,
            ])
            ->setSubject('Восстановление пароля на сайте elisdn.ru')
            ->setTo($this->email);
        if (!$mail->send()) {
            throw new \RuntimeException('Unable to send remind to ' . $this->email);
        }
    }

    public function updateCommentsStat(): void
    {
        $this->updateCommentsCount();
        $this->updateAttributes(['comments_count' => $this->comments_count]);
    }

    protected function updateCommentsCount(): void
    {
        $this->comments_count = $this->getCommentsCountReal();
    }
}
