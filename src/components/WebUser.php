<?php

namespace app\components;

use CWebUser;
use Yii;

class WebUser extends CWebUser
{
    public function getIsGuest(): bool
    {
        return Yii::$app->user->getIsGuest();
    }

    public function getId()
    {
        return Yii::$app->user->getId();
    }

    public function checkAccess($operation, $params = [], $allowCaching = true): bool
    {
        return Yii::$app->user->can($operation, $params, $allowCaching);
    }
}
