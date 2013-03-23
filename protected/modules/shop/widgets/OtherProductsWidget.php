<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class OtherProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
    public $category = 0;
    public $skip = 0;
	public $limit = 10;

	public function run()
	{
        if ($category = ShopCategory::model()->findByPk($this->category))
        {
            $criteria = new CDbCriteria;
            $criteria->scopes = array('published');

            $criteria->addInCondition('t.category_id', array($category->id) + $category->getChildsArray());

            $othersArray = array();
            $others = ShopProductOthercategory::model()->findAll('t.category_id=:cid', array(':cid'=>$category->id));
            foreach ($others as $other)
                $othersArray[] = $other->product_id;

            $criteria->addInCondition('t.id', array_unique($othersArray), 'OR');

            $criteria->limit = $this->limit;
            $criteria->order = 't.id DESC';

            if ($this->skip)
            {
                $criteria->addCondition('t.id<>:id');
                $criteria->params[':id'] = $this->skip;
            }

            $items = ShopProduct::model()->cache(30)->findAll($criteria);

            $this->render('OtherProducts/' . $this->tpl ,array(
                'items'=>$items,
            ));
        }
        else
            echo '[Category ' . CHtml::encode($this->category) . ' not found]';
	}

}