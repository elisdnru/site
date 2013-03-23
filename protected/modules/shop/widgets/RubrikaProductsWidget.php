<?php

Yii::import('shop.components.ShopWidget');
Yii::import('shop.models.*');
DUrlRulesHelper::import('shop');

class RubrikaProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
    public $rubrika = 0;
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        $criteria->addCondition('t.rubrika_id=:rubrika_id', $this->rubrika);
        $criteria->params[':rubrika_id'] = $this->rubrika;

        $criteria->limit = $this->limit;
        $criteria->order = 't.id DESC';

        $items = ShopProduct::model()->cache(30)->findAll($criteria);

        $this->render('RubrikaProducts/' . $this->tpl ,array(
            'items'=>$items,
        ));
	}

}