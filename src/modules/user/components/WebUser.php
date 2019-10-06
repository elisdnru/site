<?php

namespace app\modules\user\components;

use CWebUser;
use app\modules\user\models\User;

class WebUser extends CWebUser
{
    private $_model;

    function getRole()
    {
        if ($user = $this->getModel()) {
            return $user->role;
        }

        return 'role_guest';
    }

    private function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::model()->findByPk($this->id, ['select' => 'role']);
        }

        return $this->_model;
    }
}
