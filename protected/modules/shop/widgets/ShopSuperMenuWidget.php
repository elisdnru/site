<?php

Yii::import('application.modules.shop.components.ShopWidget');

class ShopSuperMenuWidget extends ShopBaseWidget
{
    public function run()
    {
         $this->render('ShopSuperMenu');
    }
}
