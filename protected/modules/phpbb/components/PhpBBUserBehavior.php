<?php
/**
 * PhpBBUserBehavior
 *
 * Automatically add/remove/update forum user
 *
 * <pre>
 * return array(
 *
 *     'modules'=>array(
 *          // ...
 *          'phpbb',
 *     }
 *
 *     'components'=>array(
 *         // ...
 *
 *         'db'=>array(
 *             'connectionString' => '...',
 *         ),

 *         'forumDb'=>array(
 *             'class'=>'CDbConnection',
 *             'connectionString' => '...',
 *             'tablePrefix' => 'phpbb_',
 *             'charset' => 'utf8',
 *         ),
 *
 *         'phpBB'=>array(
 *             'class'=>'phpbb.extensions.phpBB.phpBB',
 *             'path'=>'webroot.forum',
 *         ),
 *
 *         'image'=>array(
 *             'class'=>'ext.image.CImageHandler',
 *         ),
 *
 *         'file'=>array(
 *             'class'=>'ext.file.CFile',
 *         ),
 *     ),
 * );
 * </pre>
 *
 * <pre>
 * class User extends CActiveRecord
 * {
 *     public function behaviors()
 *     {
 *         return array(
 *             'PhpBBUserBehavior'=>array(
 *                 'class'=>'phpbb.components.PhpBBUserBehavior',
 *                 'usernameAttribute'=>'username',
 *                 'newPasswordAttribute'=>'new_password',
 *                 'emailAttribute'=>'email',
 *                 'avatarAttribute'=>'avatar',
 *                 'avatarPath'=>'webroot.upload.images.avatars',
 *                 'forumDbConnection'=>'forumDb', // default
 *                 'syncAttributes'=>array(
 *                     'site'=>'user_website',
 *                     'icq'=>'user_icq',
 *                     'from'=>'user_from',
 *                     'occ'=>'user_occ',
 *                     'interests'=>'user_interests',
 *                 )
 *             ),
 *         );
 *     }
 * }
 * </pre>
 *
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.1
 */

class PhpBBUserBehavior extends CActiveRecordBehavior
{
    /**
     * @var string User username attribute
     */
    public $usernameAttribute = 'username';
    /**
     * @var string User attribute witch contains new password
     */
    public $newPasswordAttribute = 'new_password';
    /**
     * @var string User email
     */
    public $emailAttribute = 'email';
    /**
     * @var string User attribute witch contains filename with extension
     */
    public $avatarAttribute = '';
    /**
     * @var string path like 'webroot.upload.avatars'
     */
    public $avatarPath = '';
    /**
     * @var string CDbConnection component
     */
    public $forumDbConnection = 'forumDb';
    /**
     * @var array attributes
     */
    public $syncAttributes = array();

    public function afterSave($event)
    {
        $this->_updatePassword();
        $this->_updateAttributes();
        $this->_updateAvatar();
    }

    public function afterDelete($event)
    {
        $model = $this->getOwner();
        if (isset(Yii::app()->phpBB))
            Yii::app()->phpBB->userDelete($model->{$this->usernameAttribute});
    }

    protected function _updatePassword()
    {
        $model = $this->getOwner();

        if ($model->{$this->newPasswordAttribute})
        {
            if (isset(Yii::app()->phpBB))
            {
                if ($model->getIsNewRecord())
                    Yii::app()->phpBB->userAdd($model->{$this->usernameAttribute}, $model->{$this->newPasswordAttribute}, $model->{$this->emailAttribute}, 2);
                else
                    Yii::app()->phpBB->changePassword($model->{$this->usernameAttribute}, $model->{$this->newPasswordAttribute});
            }
        }
    }

    protected function _updateAttributes()
    {
        $model = $this->getOwner();

        $user = $this->_loadBBUserModel($model->{$this->usernameAttribute});
        if (!$user) return;

        $attrs = array(
            'user_id' => $user->getPrimaryKey(),
            'username' => $model->{$this->usernameAttribute},
            'user_email' => $model->{$this->emailAttribute},
        );

        foreach ($this->syncAttributes as $attribute => $forumAttribute)
        {
            $attrs[$forumAttribute] = $model->{$attribute};
        }

        Yii::app()->phpBB->user_update($attrs);
    }

    protected function _updateAvatar()
    {
        if (!$this->avatarAttribute || !$this->avatarPath)
            return;

        $model = $this->getOwner();

        $user = $this->_loadBBUserModel($model->{$this->usernameAttribute});
        if (!$user) return;

        if ($model->{$this->avatarAttribute})
        {
            $originalFile = Yii::getPathOfAlias($this->avatarPath) . DIRECTORY_SEPARATOR . $model->{$this->avatarAttribute};

            $file = Yii::app()->file->set($originalFile);   /* @var $file CFile */
            $orig = Yii::app()->image->load($originalFile); /* @var $orig CImageHandler */

            $this->_deleteAvatar($user);

            $forumFileName = $this->forumAvatarSalt . '_' . $user->getPrimaryKey() . '.' . $file->getExtension();
            $forumFile = $this->forumAvatarPath . DIRECTORY_SEPARATOR . $forumFileName;

            $thumb = $orig->thumb($this->forumAvatarWidth, 5000)->save($forumFile, false, 100);

            $user->user_avatar = $user->getPrimaryKey() . '_' . time()  . '.' . $file->getExtension();
            $user->user_avatar_type = 1;
            $user->user_avatar_width = $thumb->getWidth();
            $user->user_avatar_height = $thumb->getHeight();
            $user->save();
        }
        else
        {
            $this->_deleteAvatar($user);
            $user->save();
        }
    }

    protected function _loadBBUserModel($username)
    {
        return PhpBBUser::model()->findByName($username);
    }

    protected function _deleteAvatar($user)
    {
        if ($user->user_avatar)
        {
            $oldForumFile = $this->forumAvatarPath . DIRECTORY_SEPARATOR . $this->forumAvatarSalt . '_' . $user->user_avatar;
            @unlink($oldForumFile);
        }

        $user->user_avatar_type = 0;
        $user->user_avatar_width = 0;
        $user->user_avatar_height = 0;
    }

    protected $_avatarPath;

    protected function getForumAvatarPath()
    {
        if ($this->_avatarPath === null)
            $this->_avatarPath = Yii::getPathOfAlias(Yii::app()->phpBB->path) . DIRECTORY_SEPARATOR . $this->getConfigValue('avatar_path');
        return $this->_avatarPath;
    }

    protected function getForumAvatarSalt()
    {
        return $this->getConfigValue('avatar_salt');
    }

    protected function getForumAvatarWidth()
    {
        return $this->getConfigValue('avatar_max_width');
    }

    protected $_configData = array();

    protected function getConfigValue($param)
    {
        if (!isset($this->_configData[$param]))
            $this->_configData[$param] =  Yii::app()->{$this->forumDbConnection}->createCommand('SELECT `config_value` FROM {{config}} WHERE `config_name`=:param')->queryScalar(array(':param'=>$param));

        return $this->_configData[$param];
    }
}
