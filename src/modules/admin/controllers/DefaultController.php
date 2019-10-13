<?php

namespace app\modules\admin\controllers;

use app\modules\user\models\Access;
use app\components\AdminController;
use Yii;

class DefaultController extends AdminController
{
    public function accessRules()
    {
        return [
            ['allow',
                'roles' => [Access::ROLE_CONTROL],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex()
    {
        if (count(Yii::app()->modules)) {
            foreach (Yii::app()->modules as $key => $value) {
                $key = strtolower($key);
                $module = Yii::app()->getModule($key);

                if ($module) {
                    if ($module instanceof \app\components\system\WebModule && Yii::app()->moduleManager->allowed($module->id)) {
                        $modules[$module->group ?? 'Прочее'][$module->name] = $module;
                    }
                }
            }
        }

        ksort($modules);

        $this->render('index', [
            'modules' => $modules,
            'user' => $this->getUser(),
        ]);
    }
}
