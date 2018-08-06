<?php

Yii::import('application.modules.user.models.*');

class WebUser extends CWebUser
{
    private $_model = null;

    function getRole()
    {
        if ($user = $this->getModel()) {
            return $user->role;
        } else {
            return 'role_guest';
        }
    }

    private function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::model()->findByPk($this->id, ['select' => 'role']);
        }

        return $this->_model;
    }
}
