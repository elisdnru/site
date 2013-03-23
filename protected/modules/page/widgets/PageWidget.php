<?php

DUrlRulesHelper::import('page');

class PageWidget extends DWidget
{
	public $alias;
	
	public function run()
	{
		 $page = Page::model()->cache(1000)->findByPath($this->alias);
         $this->render('Page', array('page'=>$page));
	}
}