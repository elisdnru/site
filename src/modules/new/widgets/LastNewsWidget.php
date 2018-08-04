<?php

DUrlRulesHelper::import('new');
Yii::import('application.modules.new.models.*');
Yii::import('application.modules.page.models.Page');

class LastNewsWidget extends DWidget
{
    public $tpl = 'default';
	public $title = '';
	public $class = '';
	public $label = '';
	public $page = '';
	public $limit = 6;
	public $childs = true;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        if ($this->page)
        {
            if (!$this->page instanceof Page)
                $page = Page::model()->findByPath($this->page);
            else
                $page = $this->page;

            if (!$page)
                return;

            if ($this->childs)
            {
                $pages = NewsPage::model()->getPagesArray($page->id);
                $criteria->addInCondition('page_id', $pages);
            }
            else
            {
                $criteria->addCondition('page_id=:category');
                $criteria->params[':category'] = $page->id;
            }

        } else
            $page = new Page;

        if ($this->tpl == 'mainpage')
            $criteria->addCondition('inhome=0');

        $criteria->limit = $this->limit;
        $criteria->order = 'date desc';

        $news = News::model()->findAll($criteria);

		$this->render('LastNews/'.$this->tpl ,array(
            'news'=>$news,
            'title'=>$this->title,
            'label'=>$this->label,
            'class'=>$this->class,
            'page'=>$page,
        ));
	}

}