<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class PopularProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->addCondition('popular = 1');
        $criteria->limit = $this->limit;
        $criteria->order = 'id DESC';

        $items = ShopProduct::model()->cache(3600)->findAll($criteria);

		$this->render('PopularProducts/' . $this->tpl ,array(
            'items'=>$items,
        ));
	}

}