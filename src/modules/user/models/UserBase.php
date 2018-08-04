<?php

Yii::import('application.modules.comment.models.*');
Yii::import('application.modules.attribute.components.*');

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
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
 * @property string $zip
 * @property string $address
 * @property string $phone
 * @property string $site
 * @property string $googleplus
 *
 * @property Page[] $access_pages
 * @property int $comments_count
 * @property string $fio
 */
abstract class UserBase extends CActiveRecord
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

    protected $_salt = '%#w_wrb13&p';

	/**
	 * @return UserBase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array_merge(array(

            // Login
			array(
                'username',
                'required',
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),
            array(
                'username',
                'length',
                'max'=>255,
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),
			array(
                'username',
                'match',
                'pattern' => '#^[a-zA-Z0-9_\.-]+$#',
                'message' => 'Логин содержит запрещённые символы',
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),
            array(
                'username',
                'unique',
                'caseSensitive' => false,
                'className' => 'User',
                'message' => 'Такой {attribute} уже используется',
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),

            // Email
            array(
                'email',
                'required',
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),
            array(
                'email',
                'email',
                'message' => 'Неверный формат E-mail адреса',
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),
            array(
                'email',
                'length',
                'max'=>255 ,
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),
            array(
                'email',
                'unique',
                'caseSensitive' => false,
                'className' => 'User',
                'message' => 'Такой {attribute} уже используется',
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),

            // Password
            array(
                'new_password',
                'required',
                'on'=>array(
                    self::SCENARIO_REGISTER,
                    self::SCENARIO_ADMIN_CREATE,
                )
            ),
            array(
                'new_password',
                'length',
                'min'=>6,
                'max'=>255,
                'allowEmpty'=>true
            ),
            array(
                'new_password',
                'filter',
                'filter'=>'trim'
            ),

            array(
                'new_confirm',
                'compare',
                'compareAttribute' => 'new_password',
                'message'=>'Пароли не совпадают'
            ),

            // Login
            array(
                'role',
                'required',
                'on'=>array(
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),

            // Active
            array(
                'active',
                'numerical',
                'integerOnly'=>true,
                'on'=>array(
                    self::SCENARIO_ADMIN_CREATE,
                    self::SCENARIO_ADMIN_UPDATE,
                )
            ),

            // Avatar
            array(
                'del_avatar',
                'safe'
            ),

            // Name
            array(
                'lastname, name',
                'required'
            ),
            array(
                'lastname, name, middlename',
                'length',
                'max'=>255
            ),

            // Zip
            array(
                'zip',
                'length',
                'max'=>255
            ),

            // Address
            array(
                'address',
                'safe'
            ),

            // Phone
            array(
                'phone',
                'length',
                'max'=>255
            ),

            // Site
            array(
                'site',
                'url'
            ),
            array(
                'site',
                'length',
                'max'=>255
            ),

            // GooglePlus
            array(
                'googleplus',
                'url'
            ),
            array(
                'googleplus',
                'length',
                'max'=>255
            ),

            array(
                'verifyCode',
                'captcha',
                'allowEmpty' => !CCaptcha::checkRequirements() || !Yii::app()->user->isGuest,
                'message' => 'Код подтверждения введён неверно',
                'captchaAction'=>'/user/default/captcha',
                'on' => array(
                    self::SCENARIO_REGISTER
                ),
            ),

            array('id, username, password, email, fio, create_datetime, last_modify_datetime, last_visit_datetime, active, identity, network, lastname, name, middlename, role', 'safe', 'on'=>'search'),
		), DAttributeHelper::rules('User'));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'access_pages'=>array(self::HAS_MANY, 'UserPage', 'user_id'),
            'access_pages_full'=>array(self::MANY_MANY, 'Page', 'user_page(user_id, page_id)'),
            'comments_count_real' => array(self::STAT, 'Comment', 'user_id',
                'condition'=>'public=1',
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array_merge(array(
			'id' => 'ID',
			'username' => 'Логин',
			'password' => 'Пароль',
			'new_password' => 'Новый пароль',
            'new_confirm' => 'Подтверждение пароля',
            'old_password' => 'Текущий пароль',
			'email' => 'Email',
			'confirm' => 'Ключ подтверждения',
			'role' => 'Роль',
			'access_pages' => 'Доступные для редактирования только страницы',
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
            'zip' => 'Почтовый индекс',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'site' => 'Сайт',
            'googleplus' => 'Профиль в Google+',
		), DAttributeHelper::attributeLabels('User'));
	}

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
	public function search($pageSize=10)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.username',$this->username,true);
        $criteria->compare(new CDbExpression("CONCAT(t.lastname, ' ', t.name, ' ', t.middlename)"), $this->fio, true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.identity',$this->identity,true);
		$criteria->compare('t.network',$this->network,true);
		$criteria->compare('t.confirm',$this->confirm,true);
		$criteria->compare('t.role',$this->role);
        $criteria->compare('t.create_datetime',$this->create_datetime,true);
        $criteria->compare('t.last_modify_datetime',$this->last_modify_datetime,true);
        $criteria->compare('t.last_visit_datetime',$this->last_visit_datetime,true);
        $criteria->compare('t.active',$this->active,true);
        $criteria->compare('t.avatar',$this->avatar,true);
        $criteria->compare('t.comments_count',$this->comments_count,true);

        $criteria->compare('t.lastname',$this->lastname,true);
        $criteria->compare('t.name',$this->name,true);
        $criteria->compare('t.middlename',$this->middlename,true);
        $criteria->compare('t.zip',$this->zip,true);
        $criteria->compare('t.address',$this->address,true);
        $criteria->compare('t.phone',$this->phone,true);
        $criteria->compare('t.site',$this->site,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.id DESC',
                'attributes'=>array(
                    'username',
                    'email',
                    'fio'=>array(
                        'asc'=>'t.lastname ASC, t.name ASC, t.middlename ASC',
                        'desc'=>'t.lastname DESC, t.name DESC, t.middlename ASC',
                    ),
                    'role',
                    'date'=>array(
                        'asc'=>'t.create_datetime ASC',
                        'desc'=>'t.create_datetime DESC',
                    ),
                )
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
	}

    public function behaviors()
    {
        return array(
            'CTimestamp'=>array(
                'class'=>'zii.behaviors.CTimestampBehavior',
                'createAttribute'=>'create_datetime',
                'updateAttribute'=>'last_modify_datetime',
                'setUpdateOnCreate'=>true,
            ),
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'avatar',
                'deleteAttribute'=>'del_avatar',
                'filePath'=>self::IMAGE_PATH,
                'defaultThumbWidth'=>self::IMAGE_WIDTH,
            ),
            'DAttribute'=>array(
                'class'=>'attribute.components.DAttributeBehavior',
            ),
        );
    }

    protected function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->new_password)
            {
                $this->salt = $this->generateSalt();
                $this->password = $this->hashPassword($this->new_password, $this->salt);
            }

            if (!$this->role)
                $this->role = Access::ROLE_USER;

            $this->updateCommentsCount();
            return true;
        }
        return false;
    }

    public function validatePassword($password)
    {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    /**
     * Generates the password hash.
     * @param string $password
     * @param string $salt
     * @return string hash
     */
    public function hashPassword($password, $salt)
    {
        return md5($this->_salt . $salt . $password);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    protected function generateSalt()
    {
        return uniqid('',true);
    }

    private $_fio;

    public function getFio()
    {
        if ($this->_fio === null){
            $this->_fio = trim($this->lastname . ' ' . $this->name . ' ' . $this->middlename);
            if (!$this->_fio) $this->_fio = $this->username;
        }
        return $this->_fio;
    }

    public function setFio($value)
    {
        $this->_fio = $value;
    }

    public function getAccessPagesArray()
    {
        $array = array();

        foreach ($this->access_pages as $page)
            $array[] = $page->page_id;

        return $array;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
            DUrlRulesHelper::import('user');
            $this->_url = Yii::app()->createUrl('/user/users/show', array('username'=>$this->username));
        }
        return $this->_url;
    }

    private $_avatarUrl;

    public function getAvatarUrl($width=self::IMAGE_WIDTH, $height=self::IMAGE_HEIGHT)
    {
        if ($this->_avatarUrl === null)
        {
            if (preg_match('|^https?:\/\/|', $this->avatar))
                $this->_avatarUrl = $this->avatar;
            elseif ($this->avatar)
                $this->_avatarUrl = Yii::app()->request->baseUrl . '/' . Yii::app()->uploader->getThumbUrl(self::IMAGE_PATH, $this->avatar, $width, $height);
            else
                $this->_avatarUrl = $this->getDefaultAvatarUrl($width);
        }

        return $this->_avatarUrl;
    }

    public function getDefaultAvatarUrl($width)
    {
        return DGRavatarHelper::get($this->email, $width);
    }

    public function sendCommit()
    {
        if (!$this->id) return;

        $this->confirm = md5(microtime());

        Yii::app()->db
            ->createCommand('UPDATE ' . $this->tableName() . ' SET `confirm`=:confirm WHERE `id`=:id')
            ->execute(array(':confirm'=>$this->confirm, ':id'=>$this->id));

        $email = Yii::app()->email;
        $email->to = $this->email;
        $email->subject = 'Подтверждение регистрации на сайте '.$_SERVER['SERVER_NAME'];
        $email->message = '';
        $email->view = 'confirm';
        $email->viewVars = array(
            'user'=>$this,
            'confirmUrl'=>Yii::app()->createAbsoluteUrl('/user/default/confirm', array('code'=>$this->confirm)),
        );
        $email->send();
    }

    public function sendRemind()
    {
        $email = Yii::app()->email;
        $email->to = $this->email;
        $email->subject = 'Восстановление пароля на сайте '.$_SERVER['SERVER_NAME'];
        $email->message = '';
        $email->view = 'remind';
        $email->viewVars = array(
            'user'=>$this,
        );
        $email->send();
    }

    public function updateCommentsStat()
    {
        $this->updateCommentsCount();
        $this->updateByPk($this->id, array('comments_count'=>$this->comments_count));
    }

    protected  function updateCommentsCount()
    {
        $this->comments_count = $this->comments_count_real;
    }
}