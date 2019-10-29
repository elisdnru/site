<?php

namespace app\components;

use app\modules\user\models\User;
use yii\rbac\Assignment;
use yii\rbac\PhpManager;

class V2UserAuthManager extends PhpManager
{
    public function getAssignments($userId): array
    {
        if (array_key_exists($userId, $this->assignments)) {
            return $this->assignments[$userId];
        }

        if (!$user = User::findOne($userId)) {
            return $this->assignments[$userId] = [];
        }

        return $this->assignments[$userId] = [
            $user->role => new Assignment([
                'userId' => $user->id,
                'roleName' => $user->role,
                'createdAt' => time()
            ])
        ];
    }
}
