<?php

namespace app\modules\main\components;

use app\components\module\ModuleAdminFilter;
use CHttpException;
use Yii;

abstract class AdminController extends Controller
{
    public $layout = '//layouts/page/admin';

    public function filters()
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