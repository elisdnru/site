<?php

DUrlRulesHelper::import('new');

class OtherNewsWidget extends DWidget
{
    public $tpl = 'OtherNews';
	public $title = '';
	public $class = '';
	public $label = '';
	public $page = '';
	public $skip = 0;
	public $limit = 5;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        if ($this->page)
        {
            if (!$page = Page::model()->findByPath(trim($this->page, '/')))
                return;

            $criteria->addCondition('page_id=:cat AND id <> :skip');
            $criteria->params[':cat'] = $page->id;
            $criteria->params[':skip'] =$this->skip;
        }
        else
        {
            $criteria->addCondition('id <> :skip');
            $criteria->params[':skip'] =$this->skip;
            $page = new Page();
        }

        $criteria->limit = $this->limit;
        $criteria->order = 'date DESC';

        $news = News::model()->findAll($criteria);

		$this->render($this->tpl ,array(
            'news'=>$news,
            'title'=>$this->title,
            'label'=>$this->label,
            'class'=>$this->class,
            'page'=>$page,
        ));
	}

}