<?php

namespace app\modules\user\models;

use app\components\helpers\GravatarHelper;
use Yii;

class User extends UserBase
{
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
