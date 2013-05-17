<?php

Yii::import('application.modules.booksru.models.Book');
DUrlRulesHelper::import('booksru');

class BooksWidget extends DWidget
{
    public $tpl = 'default';
	public $limit = 6;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('free');

        $criteria->limit = $this->limit;
        $criteria->order = 'RAND()';

        $books = Book::model()->findAll($criteria);

		$this->render('Books/'.$this->tpl ,array(
            'books'=>$books,
        ));
	}
}