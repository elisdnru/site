<?php

namespace app\modules\user\components;

use CWebUser;
use app\modules\user\models\User;

class WebUser extends CWebUser
{
    private $_model;

    function getRole(): string
    {
        if ($user = $this->getModel()) {
            return $user->role;
        }

        return 'role_guest';
    }

    private function getModel(): User
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::findOne($this->id);
        }

        return $this->_model;
    }
}
