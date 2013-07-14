<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class SaleProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->addCondition('sale = 1');

        if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE'))
            $criteria->group = 't.title';

        $criteria->limit = $this->limit;
        $criteria->order = 'id DESC';

        $items = ShopProduct::model()->cache(0, new Tags('shop'))->findAll($criteria);

		$this->render('SaleProducts/' . $this->tpl ,array(
            'items'=>$items,
        ));
	}

}