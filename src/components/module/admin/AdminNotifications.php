<?php

namespace app\components\module\admin;

use Yii;

class AdminNotifications
{
    /**
     * @param string $module
     * @return array[]
     */
    public function notifications(string $module): array
    {
        $class = ModuleClass::getClass(Yii::$app->getModules(), $module);

        if (!is_subclass_of($class, AdminNotificationsProvider::class)) {
            return [];
        }

        /** @var AdminNotificationsProvider $class */
        return $class::adminNotifications();
    }
}
