<?php

declare(strict_types=1);

namespace app\components;

use app\modules\user\models\User;
use Override;
use yii\rbac\Assignment;
use yii\rbac\PhpManager;

final class AuthManager extends PhpManager
{
    #[Override]
    public function getAssignments($userId): array
    {
        if (!$userId) {
            return [];
        }

        if (\array_key_exists($userId, $this->assignments)) {
            /** @var Assignment[] */
            return $this->assignments[$userId];
        }

        if (!$user = User::findOne($userId)) {
            return $this->assignments[$userId] = [];
        }

        return $this->assignments[$userId] = [
            $user->role => new Assignment([
                'userId' => $user->id,
                'roleName' => $user->role,
                'createdAt' => time(),
            ]),
        ];
    }
}
