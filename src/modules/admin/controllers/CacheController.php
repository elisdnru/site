<?php

namespace app\modules\admin\controllers;

use app\modules\user\models\Access;
use app\components\AdminController;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\Session;

class CacheController extends AdminController
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

    public function actionClear(Session $session): Response
    {
        Yii::$app->cache->flush();
        $session->setFlash('success', 'Кэш очищен');

        return $this->redirect(['default/index']);
    }
}
