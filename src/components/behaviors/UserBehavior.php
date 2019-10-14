<?php

namespace app\components\behaviors;

use CBehavior;
use CHttpException;
use app\modules\user\models\User;
use Yii;

class UserBehavior extends CBehavior
{
    protected $_user;
    protected $_access = [];

    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::model()->findByPk(Yii::app()->user->id);
        }
        return $this->_user;
    }

    public function is(string $role): bool
    {
        return Yii::app()->user->checkAccess($role);
    }

    public function check($role): void
    {
        $success = false;
        if (is_array($role)) {
            foreach ($role as $item) {
                $success = $success || $this->is($item);
            }
        } else {
            $success = $this->is($role);
        }
        if (!$success) {
            throw new CHttpException(403, 'Недостаточно прав для просмотра страницы');
        }
    }
}
