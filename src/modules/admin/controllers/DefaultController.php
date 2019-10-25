<?php

namespace app\modules\admin\controllers;

use app\components\module\Module;
use app\modules\user\models\Access;
use app\components\AdminController;
use app\modules\user\models\User;
use Yii;

class DefaultController extends AdminController
{
    public function accessRules(): array
    {
        return [
            ['allow',
                'roles' => [Access::CONTROL],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex(): void
    {
        if (count(Yii::app()->modules)) {
            foreach (Yii::app()->modules as $key => $value) {
                $key = strtolower($key);
                $module = Yii::app()->getModule($key);

                if ($module) {
                    if ($module instanceof Module && Yii::app()->moduleManager->allowed($module->id)) {
                        $modules[$module->group ?? 'Прочее'][$module->name] = $module;
                    }
                }
            }
        }

        ksort($modules);

        $this->render('index', [
            'modules' => $modules,
            'user' => $this->loadUser(),
        ]);
    }

    private function loadUser(): ?User
    {
        return User::findOne(Yii::app()->user->id);
    }
}
