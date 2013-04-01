<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class LastProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE'))
            $criteria->group = 't.title';

        $criteria->limit = $this->limit;
        $criteria->order = 'id DESC';

        $items = ShopProduct::model()->cache(3600)->published()->findAll($criteria);

		$this->render('LastProducts/' . $this->tpl ,array(
            'items'=>$items,
        ));
	}
}