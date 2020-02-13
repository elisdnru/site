<?php

namespace app\components;

use Yii;
use yii\caching\TagDependency;
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
        ];
    }

    public function beforeAction($action): bool
    {
        if (parent::beforeAction($action)) {
            $tag = $this->module->id;
            TagDependency::invalidate(Yii::$app->cache, $tag);
            return true;
        }
        return false;
    }
}
