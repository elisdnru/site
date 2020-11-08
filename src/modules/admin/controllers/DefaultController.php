<?php

namespace app\modules\admin\controllers;

use app\modules\user\models\Access;
use app\components\AdminController;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\User as WebUser;

class DefaultController extends AdminController
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

    public function actionIndex(WebUser $user): string
    {
        $modules = Yii::$app->moduleAdminDashboard->groupedModules();

        return $this->render('index', [
            'modules' => $modules,
            'user' => $this->loadUser((int)$user->id),
        ]);
    }

    private function loadUser(int $id): ?User
    {
        return User::findOne($id);
    }
}
