<?php

Yii::import('shop.components.ShopWidget');

class ShopSuperMenuWidget extends ShopBaseWidget
{
    public function run()
    {
         $this->render('ShopSuperMenu');
    }
}
