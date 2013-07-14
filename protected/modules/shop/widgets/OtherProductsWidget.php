<?php

Yii::import('application.modules.shop.components.ShopWidget');
Yii::import('application.modules.shop.models.*');
DUrlRulesHelper::import('shop');

class OtherProductsWidget extends ShopBaseWidget
{
    public $tpl = 'default';
    public $category = 0;
    public $current = false;
	public $limit = 10;

	public function run()
	{
        if ($category = ShopCategory::model()->findByPk($this->category))
        {
            $criteria = new CDbCriteria;
            $criteria->scopes = array('published');

            $criteria->addInCondition('t.category_id', CArray::merge(array($category->id), $category->getChildsArray()));

            $othersArray = array();
            $others = ShopProductOthercategory::model()->findAll('t.category_id=:cid', array(':cid'=>$category->id));
            foreach ($others as $other)
                $othersArray[] = $other->product_id;

            $criteria->addInCondition('t.id', array_unique($othersArray), 'OR');

            $criteria->limit = $this->limit;

            if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE'))
                $criteria->group = 't.title';

            $criteria->order = 't.id DESC';

            if ($this->current)
            {
                $criteria->addCondition('t.title <> :title');
                $criteria->params[':title'] = $this->current->title;
            }

            $items = ShopProduct::model()->cache(0, new Tags('shop'))->findAll($criteria);

            $this->render('OtherProducts/' . $this->tpl ,array(
                'items'=>$items,
            ));
        }
        else
            echo '[Category ' . CHtml::encode($this->category) . ' not found]';
	}

}