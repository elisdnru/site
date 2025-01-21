<?php

declare(strict_types=1);

namespace app\modules\admin\controllers;

use app\components\AdminController;
use app\components\module\admin\AdminDashboard;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\web\User as WebUser;

/**
 * @psalm-api
 */
final class DefaultController extends AdminController
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Access::CONTROL],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(WebUser $user, AdminDashboard $dashboard): string
    {
        $groups = $dashboard->groupedModules();

        return $this->render('index', [
            'groups' => $groups,
            'user' => $this->loadUser((int)$user->id),
        ]);
    }

    private function loadUser(int $id): ?User
    {
        return User::findOne($id);
    }
}
