<?php

declare(strict_types=1);

namespace app\components\module\admin;

use yii\web\User;

final readonly class AdminAccess
{
    private User $user;

    /**
     * @psalm-api
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function isGranted(string $module): bool
    {
        return $this->user->can('module_' . $module);
    }
}
