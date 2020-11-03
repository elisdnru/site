<?php

namespace app\components\module\admin;

use Yii;
use yii\base\Module;

class AdminNotifications
{
    public function allNotifications(): array
    {
        /** @var array[] $notifications */
        $notifications = [];
        /**
         * @var string $id
         * @var Module $module
         */
        foreach (Yii::$app->getModules() as $id => $module) {
            foreach ($this->notifications($id) as $notification) {
                $notifications[] = $notification;
            }
        }
        return $notifications;
    }

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
