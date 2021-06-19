<?php

declare(strict_types=1);

namespace app\modules\admin\controllers;

use app\components\AdminController;
use app\modules\user\models\Access;
use yii\caching\CacheInterface;
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

    public function actionClear(Session $session, CacheInterface $cache): Response
    {
        $cache->flush();
        $session->setFlash('success', 'Кэш очищен');

        return $this->redirect(['default/index']);
    }
}
