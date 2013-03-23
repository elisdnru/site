<?php

Yii::import('shop.components.ShopWidget');
Yii::import('shop.models.*');
DUrlRulesHelper::import('shop');

class LastProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->limit = $this->limit;
        $criteria->order = 'id DESC';

        $items = ShopProduct::model()->cache(3600)->published()->findAll($criteria);

		$this->render('LastProducts/' . $this->tpl ,array(
            'items'=>$items,
        ));
	}
}