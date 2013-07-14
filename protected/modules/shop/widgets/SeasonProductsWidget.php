<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class SeasonProductsWidget extends ShopBaseWidget
{
    public $tpl = 'SeasonProducts';
    public $category = 'sezonnoe-predlojenie';
	public $limit = 10;

	public function run()
	{
        $category = ShopCategory::model()->findByPath($this->category);
        if ($category){

            $criteria = new CDbCriteria;
            $criteria->scopes = array('published');

            $criteria->addInCondition('t.category_id', CArray::merge(array($category->id), $category->getChildsArray()));

            $othersArray = array();
            $others = ShopProductOthercategory::model()->findAll('t.category_id=:cid', array(':cid'=>$category->id));
            foreach ($others as $other)
                $othersArray[] = $other->product_id;

            $criteria->addInCondition('t.id', array_unique($othersArray), 'OR');

            if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE'))
                $criteria->group = 't.title';

            $criteria->limit = $this->limit;
            $criteria->order = 't.id DESC';

            $count = ShopProduct::model()->cache(0, new Tags('shop'))->count($criteria);
            $products = ShopProduct::model()->cache(0, new Tags('shop'))->findAll($criteria);

            $this->render($this->tpl ,array(
                'products'=>$products,
                'count'=>$count,
            ));
        } else {
            echo '[Category ' . CHtml::encode($this->category) . ' not found]';
        }

	}

}