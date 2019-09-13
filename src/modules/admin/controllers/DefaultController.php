<?php

namespace app\modules\admin\controllers;

use Access;
use app\modules\main\components\DAdminController;
use Yii;
use function is_a;

class DefaultController extends DAdminController
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
                    if (is_a($module, 'app\modules\main\components\system\DWebModule') && Yii::app()->moduleManager->allowed($module->id)) {
                        $modules[isset($module->group) ? $module->group : 'Прочее'][$module->name] = $module;
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

    public function actionClearCache()
    {
        Yii::app()->cache->flush();
        Yii::app()->user->setFlash('success', 'Кэш очищен');
        $this->redirect(['index']);
    }
}
