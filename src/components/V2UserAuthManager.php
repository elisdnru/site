<?php

namespace app\components;

use app\modules\user\models\User;
use Yii;
use yii\rbac\Assignment;
use yii\rbac\PhpManager;

class V2UserAuthManager extends PhpManager
{
    public function init(): void
    {
        parent::init();

        if (!Yii::$app->has('user')) {
            return;
        }

        if (Yii::$app->user->getIsGuest()) {
            return;
        }

        if (!$user = User::findOne(Yii::$app->user->getId())) {
            return;
        }

        $this->assignments[$user->id][$user->role] = new Assignment([
            'userId' => $user->id,
            'roleName' => $user->role,
            'createdAt' => time(),
        ]);
    }
}
