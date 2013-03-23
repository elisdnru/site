<?php

Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class ShopCartWidget extends DWidget
{
    public $tpl = 'default';

    public function run()
    {
        $items = Yii::app()->shopcart->getAssoc();

        $this->render('ShopCart/'.$this->tpl ,array(
            'items'=>$items,
        ));
    }
}
