<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

abstract class DAdminController extends DController
{
    public $layout = '//layouts/page/admin';

    public function filters()
    {
        return array_merge(parent::filters(), [
            ['module.components.DModuleAdminFilter'],
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
