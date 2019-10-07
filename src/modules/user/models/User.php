<?php

namespace app\modules\user\models;

use app\components\ActiveRecord;
use app\components\helpers\GravatarHelper;
use CActiveDataProvider;
use CCaptcha;
use CDbCriteria;
use CDbExpression;
use Yii;

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
 * @property string $fio
 */
class User extends ActiveRecord
{
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_SETTINGS = 'settings';
    const SCENARIO_ADMIN_CREATE = 'admin_create';
    const SCENARIO_ADMIN_UPDATE = 'admin_update';
    const SCENARIO_SEARCH = 'search';

    const IMAGE_PATH = 'upload/images/users/avatars';
    const IMAGE_WIDTH = 100;
    const IMAGE_HEIGHT = 100;

    public $new_password;
    public $new_confirm;
    public $old_password;
    public $del_avatar = false;

    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
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
                'length',
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
                'caseSensitive' => false,
                'className' => \app\modules\user\models\User::class,
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
                'length',
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
                'caseSensitive' => false,
                'className' => \app\modules\user\models\User::class,
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
                'length',
                'min' => 6,
                'max' => 255,
                'allowEmpty' => true
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

            ['old_password', \app\modules\user\components\CurrentPasswordValidator::class, 'className' => self::class, 'validateMethod' => 'validatePassword', 'dependsOnAttributes' => ['new_password'], 'on' => 'settings'],


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
                'numerical',
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
                'lastname, name',
                'required'
            ],
            [
                'lastname, name, middlename',
                'length',
                'max' => 255
            ],

            // Site
            [
                'site',
                'url'
            ],
            [
                'site',
                'length',
                'max' => 255
            ],

            [
                'verifyCode',
                'captcha',
                'allowEmpty' => !CCaptcha::checkRequirements() || !Yii::app()->user->isGuest,
                'message' => 'Код подтверждения введён неверно',
                'captchaAction' => '/user/default/captcha',
                'on' => [
                    self::SCENARIO_REGISTER
                ],
            ],

            ['id, username, password, email, fio, create_datetime, last_modify_datetime, last_visit_datetime, active, identity, network, lastname, name, middlename, role', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'comments_count_real' => [self::STAT, \app\modules\comment\models\Comment::class, 'user_id',
                'condition' => 'public=1',
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare(new CDbExpression("CONCAT(t.lastname, ' ', t.name, ' ', t.middlename)"), $this->fio, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.identity', $this->identity, true);
        $criteria->compare('t.network', $this->network, true);
        $criteria->compare('t.confirm', $this->confirm, true);
        $criteria->compare('t.role', $this->role);
        $criteria->compare('t.create_datetime', $this->create_datetime, true);
        $criteria->compare('t.last_modify_datetime', $this->last_modify_datetime, true);
        $criteria->compare('t.last_visit_datetime', $this->last_visit_datetime, true);
        $criteria->compare('t.active', $this->active, true);
        $criteria->compare('t.avatar', $this->avatar, true);
        $criteria->compare('t.comments_count', $this->comments_count, true);

        $criteria->compare('t.lastname', $this->lastname, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.middlename', $this->middlename, true);
        $criteria->compare('t.site', $this->site, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.id DESC',
                'attributes' => [
                    'username',
                    'email',
                    'fio' => [
                        'asc' => 't.lastname ASC, t.name ASC, t.middlename ASC',
                        'desc' => 't.lastname DESC, t.name DESC, t.middlename ASC',
                    ],
                    'role',
                    'date' => [
                        'asc' => 't.create_datetime ASC',
                        'desc' => 't.create_datetime DESC',
                    ],
                ]
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }

    public function behaviors()
    {
        return [
            'CTimestamp' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_datetime',
                'updateAttribute' => 'last_modify_datetime',
                'setUpdateOnCreate' => true,
            ],
            'ImageUpload' => [
                'class' => \app\components\uploader\FileUploadBehavior::class,
                'fileAttribute' => 'avatar',
                'deleteAttribute' => 'del_avatar',
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
            ],
        ];
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
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

    public function validatePassword($password)
    {
        return
            password_verify($password, $this->password) ||
            $this->oldHashPassword($password) === $this->password;
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function oldHashPassword($password)
    {
        return md5('%#w_wrb13&p' . $this->salt . $password);
    }

    private $_fio;

    public function getFio()
    {
        if ($this->_fio === null) {
            $this->_fio = trim($this->lastname . ' ' . $this->name . ' ' . $this->middlename);
            if (!$this->_fio) {
                $this->_fio = $this->username;
            }
        }
        return $this->_fio;
    }

    public function setFio($value)
    {
        $this->_fio = $value;
    }

    private $_avatarUrl;

    public function getAvatarUrl($width = self::IMAGE_WIDTH, $height = self::IMAGE_HEIGHT)
    {
        if ($this->_avatarUrl === null) {
            if (preg_match('|^https?:\/\/|', $this->avatar)) {
                $this->_avatarUrl = $this->avatar;
            } elseif ($this->avatar) {
                $this->_avatarUrl = '/' . Yii::app()->uploader->getThumbUrl(self::IMAGE_PATH, $this->avatar, $width, $height);
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

    public function sendCommit()
    {
        if (!$this->id) {
            return;
        }

        $this->confirm = md5(microtime());

        Yii::app()->db
            ->createCommand('UPDATE ' . $this->tableName() . ' SET `confirm`=:confirm WHERE `id`=:id')
            ->execute([':confirm' => $this->confirm, ':id' => $this->id]);

        $email = Yii::app()->email;
        $email->to = $this->email;
        $email->subject = 'Подтверждение регистрации на сайте ' . $_SERVER['SERVER_NAME'];
        $email->message = '';
        $email->view = 'confirm';
        $email->viewVars = [
            'user' => $this,
            'confirmUrl' => Yii::app()->createAbsoluteUrl('/user/default/confirm', ['code' => $this->confirm]),
        ];
        $email->send();
    }

    public function sendRemind()
    {
        $email = Yii::app()->email;
        $email->to = $this->email;
        $email->subject = 'Восстановление пароля на сайте ' . $_SERVER['SERVER_NAME'];
        $email->message = '';
        $email->view = 'remind';
        $email->viewVars = [
            'user' => $this,
        ];
        $email->send();
    }

    public function updateCommentsStat()
    {
        $this->updateCommentsCount();
        $this->updateByPk($this->id, ['comments_count' => $this->comments_count]);
    }

    protected function updateCommentsCount()
    {
        $this->comments_count = $this->comments_count_real;
    }
}
