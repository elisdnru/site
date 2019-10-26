<?php

namespace app\components;

use app\components\module\ModuleAdminFilter;
use CHttpException;
use Yii;
use yii\caching\TagDependency;

abstract class AdminController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function filters(): array
    {
        return array_merge(parent::filters(), [
            [ModuleAdminFilter::class],
            'postOnly + delete, toggle',
        ]);
    }

    public function beforeAction($action): bool
    {
        $tag = $this->getModule()->getId();
        Yii::app()->cache->clear($tag);
        TagDependency::invalidate(Yii::$app->cache, $tag);

        if (Yii::app()->user->isGuest) {
            throw new CHttpException(403, 'Отказано в доступе');
        }

        return parent::beforeAction($action);
    }
}
