<?php

Yii::import('application.modules.shop.components.ShopHelper');

abstract class ShopBaseController extends DController
{
    protected function beforeAction($action)
    {
        ShopModule::registerScripts();
        return parent::beforeAction($action);
    }
}
