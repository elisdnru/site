<?php

DUrlRulesHelper::import('page');

class SubPagesWidget extends DWidget
{
    public $tpl = 'default';
	public $class = '';
	public $page = '';
	public $limit = 1000;
	public $images = false;

	public function run()
	{
        if (!$this->page)
            $this->page = (!empty($_GET['path']) ? $_GET['path'].'/' : '').$_GET['alias'];

        if (!$this->page)
            echo ('<div class="flash-error">[*SubPages|page=?*]</div>');

        if (!$page = Page::model()->findByPath($this->page))
            return;

        $child_pages = Page::model()->findAll(array(
            'condition'=>'parent_id=:p',
            'params'=>array(':p'=>$page->id),
            'limit'=>$this->limit,
            'order'=>'title'
        ));

		$this->render('SubPages/'.$this->tpl ,array(
            'class'=>$this->class,
            'pages'=>$child_pages,
            'images'=>$this->images,
        ));
	}

}