<?php

Yii::import('application.modules.interest.models.InretestItem');
DUrlRulesHelper::import('interest');

class InterestWidget extends DWidget
{
    public $tpl = 'default';
	public $limit = 6;

	public function run()
	{
        $criteria = new CDbCriteria;

        $criteria->limit = $this->limit;
        $criteria->order = 'RAND()';

        $books = InterestItem::model()->findAll($criteria);

		$this->render('Interest/'.$this->tpl ,array(
            'books'=>$books,
        ));
	}
}