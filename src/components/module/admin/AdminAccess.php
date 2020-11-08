<?php

namespace app\components\module\admin;

use yii\web\User;

class AdminAccess
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function isGranted(string $module): bool
    {
        return $this->user->can('module_' . $module);
    }
}
