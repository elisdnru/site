<?php

declare(strict_types=1);

namespace yii\base;

use app\components\module\admin\AdminAccess;
use app\components\module\admin\AdminDashboard;
use app\components\module\admin\AdminMenu;
use app\components\module\admin\AdminNotifications;
use app\components\uploader\Uploader;
use app\extensions\file\File;
use app\extensions\image\ImageHandler;

/**
 * @property AdminAccess $moduleAdminAccess
 * @property AdminDashboard $moduleAdminDashboard
 * @property AdminMenu $moduleAdminMenu
 * @property AdminNotifications $moduleAdminNotifications
 * @property ImageHandler $image
 * @property File $file
 * @property Uploader $uploader
 */
class Application extends Module
{

}
