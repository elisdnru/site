<?php

Yii::import('shop.components.ShopHelper');

abstract class ShopBaseWidget extends DWidget
{
    public function __construct($owner=null)
    {
        ShopModule::registerScripts();
        parent::__construct($owner);
    }
}
