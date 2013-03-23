<?php

Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class ShopSearchFormWidget extends DWidget
{
    public $tpl = 'ShopSearchForm';

    public function run()
    {
        $form = new ShopSearchForm;

        if (isset($_REQUEST['ShopSearchForm']))
            $form->attributes = $_REQUEST['ShopSearchForm'];

        $this->render($this->tpl ,array(
            'form'=>$form,
        ));
    }
}
