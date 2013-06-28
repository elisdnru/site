<?php

/**
 * This is the model class for table "{{user}}".
 *
 * @property PhpBBUser phpBbUser
 */
class User extends UserBase
{
    protected $_salt = '%#w_wrb13&p';

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            // Settings
            // array('old_password', 'required', 'on' => 'settings'),
            array('old_password', 'DCurrentPassword', 'className'=>'User', 'validateMethod'=>'validatePassword', 'dependsOnAttributes'=>array('new_password'), 'on'=>'settings'),
		));
	}

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = parent::relations();

        if (Yii::app()->moduleManager->active('phpbb'))
        {
            Yii::import('application.modules.phpbb.models.*');
            $relations = array_merge($relations, array(
                'phpBbUser'=>array(self::HAS_ONE, 'PhpBBUser', array('username'=>'username')),
            ));
        }

        return $relations;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        if (Yii::app()->moduleManager->active('phpbb'))
        {
            $behaviors = array_merge($behaviors, array(
                'PhpBBUserBehavior'=>array(
                    'class'=>'phpbb.components.PhpBBUserBehavior',
                    'usernameAttribute'=>'username',
                    'newPasswordAttribute'=>'new_password',
                    'emailAttribute'=>'email',
                    'avatarAttribute'=>'avatar',
                    'avatarPath'=>Yii::getPathOfAlias('webroot.upload.images.users.avatars'),
                    'syncAttributes' => array(
                        'site'=>'user_website',
                        'icq'=>'user_icq',
                        'from'=>'user_from',
                        'occ'=>'user_occ',
                        'interests'=>'user_interests',
                    ),
                ),
            ));
        }

        if (Yii::app()->moduleManager->active('userphoto'))
        {
            $behaviors = array_merge($behaviors, array(
                'UserPhotosBehavior'=>array(
                    'class'=>'userphoto.components.UserPhotosBehavior',
                )
            ));
        }

        return $behaviors;
    }

    public function getDefaultAvatarUrl($width)
    {
        return DGRavatarHelper::get($this->email, $width, Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/core/images/noavatar.png');
    }
}