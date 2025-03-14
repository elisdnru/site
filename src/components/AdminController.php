<?php

declare(strict_types=1);

namespace app\components;

use Override;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

abstract class AdminController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    #[Override]
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['module_' . $this->module->id],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'toggle' => ['post'],
                ],
            ],
            'cacheFlush' => [
                'class' => CacheFlushBehavior::class,
            ],
        ];
    }
}
