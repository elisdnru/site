<?php

Yii::import('review.models.Review');

class ReviewsWidget extends DWidget
{
    public $tpl = 'default';
	public $limit = 6;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        $criteria->limit = $this->limit;
        $criteria->order = 'date DESC';

        $reviews = Review::model()->findAll($criteria);

		$this->render('Reviews/'.$this->tpl ,array(
            'reviews'=>$reviews,
        ));
	}
}