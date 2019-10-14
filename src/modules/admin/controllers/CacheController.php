<?php

namespace app\modules\admin\controllers;

use app\modules\user\models\Access;
use app\components\AdminController;
use Yii;

class CacheController extends AdminController
{
    public function accessRules(): array
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

    public function actionClear(): void
    {
        Yii::app()->cache->flush();
        Yii::app()->user->setFlash('success', 'Кэш очищен');
        $this->redirect(['default/index']);
    }
}
