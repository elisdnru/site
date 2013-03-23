<?php

Yii::import('shop.components.ShopHelper');

abstract class ShopBaseController extends DController
{
    protected function beforeAction($action)
    {
        ShopModule::registerScripts();
        return parent::beforeAction($action);
    }
}
