<?php

namespace app\components;

use CPhpAuthManager;
use Yii;

class PhpAuthManager extends CPhpAuthManager
{
    public function init(): void
    {
        if ($this->authFile === null) {
            $this->authFile = Yii::getPathOfAlias('application') . '/../config/auth.php';
        }

        parent::init();

        if (!Yii::app()->user->isGuest) {
            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
        }
    }
}
