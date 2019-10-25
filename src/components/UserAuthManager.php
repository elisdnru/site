<?php

namespace app\components;

use app\modules\user\models\User;
use CPhpAuthManager;
use Yii;

class UserAuthManager extends CPhpAuthManager
{
    public function init(): void
    {
        parent::init();

        if (Yii::app()->user->isGuest) {
            return;
        }

        if (!$user = User::findOne(Yii::app()->user->id)) {
            return;
        }

        $this->assign($user->role, Yii::app()->user->id);
    }
}
