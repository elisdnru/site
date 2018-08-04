<?php

/**
 * This is the model class for table "{{user}}".
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

    public function behaviors()
    {
        $behaviors = parent::behaviors();

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