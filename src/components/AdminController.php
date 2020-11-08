<?php

namespace app\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

abstract class AdminController extends Controller
{
    public $layout = '@app/views/layouts/admin';

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
                'class' => CacheFlushBehavior::class
            ],
        ];
    }
}
