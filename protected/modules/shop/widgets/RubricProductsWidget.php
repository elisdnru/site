<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class RubricProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
    public $rubric = 0;
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        $criteria->with = array('product_rubrics'=>array('together'=>true));

        $criteria->addCondition('product_rubrics.rubric_id=:rubric_id', $this->rubric);
        $criteria->params[':rubric_id'] = $this->rubric;

        if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE'))
            $criteria->group = 't.title';

        $criteria->limit = $this->limit;
        $criteria->order = 't.id DESC';

        $items = ShopProduct::model()->cache(30)->findAll($criteria);

        $this->render('RubricProducts/' . $this->tpl ,array(
            'items'=>$items,
        ));
	}
}