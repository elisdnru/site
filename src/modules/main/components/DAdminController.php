<?php

namespace app\modules\main\components;

use app\components\module\DModuleAdminFilter;
use CHttpException;
use Yii;

abstract class DAdminController extends DController
{
    public $layout = '//layouts/page/admin';

    public function filters()
    {
        return array_merge(parent::filters(), [
            [DModuleAdminFilter::class],
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
