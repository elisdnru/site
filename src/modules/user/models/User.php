<?php

namespace app\modules\user\models;

use app\modules\main\components\helpers\GravatarHelper;
use Yii;

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
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            // Settings
            // array('old_password', 'required', 'on' => 'settings'),
            ['old_password', \app\modules\user\components\CurrentPasswordValidator::class, 'className' => self::class, 'validateMethod' => 'validatePassword', 'dependsOnAttributes' => ['new_password'], 'on' => 'settings'],
        ]);
    }

    public function getDefaultAvatarUrl($width)
    {
        return GravatarHelper::get($this->email, $width, Yii::app()->request->hostInfo . '/images/noavatar.png');
    }
}
