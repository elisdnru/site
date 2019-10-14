<?php

namespace app\components;

use app\components\module\ModuleAdminFilter;
use CHttpException;
use Yii;

abstract class AdminController extends Controller
{
    public $layout = '//layouts/admin';

    public function filters(): array
    {
        return array_merge(parent::filters(), [
            [ModuleAdminFilter::class],
            'postOnly + delete, toggle',
        ]);
    }

    public function beforeAction($action)
    {
        Yii::app()->cache->clear($this->getModule()->getId());

        if (Yii::app()->user->isGuest) {
            throw new CHttpException(403, 'Отказано в доступе');
        }

        return parent::beforeAction($action);
    }
}
