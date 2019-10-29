<?php

namespace app\components;

use Yii;
use yii\caching\TagDependency;

abstract class AdminController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function accessRules(): array
    {
        return [
            ['allow',
                'roles' => ['module_' . $this->module->id],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function filters(): array
    {
        return [
            'accessControl',
            'postOnly + delete, toggle',
        ];
    }

    public function beforeAction($action): bool
    {
        $tag = $this->getModule()->getId();
        Yii::app()->cache->clear($tag);
        TagDependency::invalidate(Yii::$app->cache, $tag);

        return parent::beforeAction($action);
    }
}
