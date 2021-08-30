<?php

declare(strict_types=1);

namespace yii\base;

use app\components\feature\FeatureToggle;
use app\components\module\admin\AdminAccess;
use app\components\module\admin\AdminDashboard;
use app\components\module\admin\AdminMenu;
use app\components\module\admin\AdminNotifications;
use app\components\uploader\Uploader;
use yii\web\User;

/**
 * @property User $user
 * @property AdminAccess $moduleAdminAccess
 * @property AdminDashboard $moduleAdminDashboard
 * @property AdminMenu $moduleAdminMenu
 * @property AdminNotifications $moduleAdminNotifications
 * @property Uploader $uploader
 * @property FeatureToggle $features
 */
class Application extends Module
{
    /**
     * @var array{
     *     deworker_api_url: string
     * }
     */
    public $params = [];
}
