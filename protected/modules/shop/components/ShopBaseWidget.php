<?php

Yii::import('application.modules.shop.components.ShopHelper');

abstract class ShopBaseWidget extends DWidget
{
    public function __construct($owner=null)
    {
        ShopModule::registerScripts();
        parent::__construct($owner);
    }
}
