<?php

Yii::import('shop.components.ShopWidget');
Yii::import('shop.models.*');
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
        $criteria->limit = $this->limit;
        $criteria->order = 'id DESC';

        $products = ShopProduct::model()->cache(30)->findAll($criteria);

		$this->render($this->tpl ,array(
            'products'=>$products,
        ));
	}

}