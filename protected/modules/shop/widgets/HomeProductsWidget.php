<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class HomeProductsWidget extends ShopBaseWidget
{
    public $tpl = 'HomeProducts';
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->addCondition('inhome = 1');

        if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE'))
            $criteria->group = 't.title';

        $criteria->limit = $this->limit;
        $criteria->order = 'id DESC';

        $products = ShopProduct::model()->cache(30)->findAll($criteria);

		$this->render($this->tpl ,array(
            'products'=>$products,
        ));
	}

}