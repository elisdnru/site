<?php

DUrlRulesHelper::import('new');

class ThemeNewsWidget extends DWidget
{
    public $tpl = 'ThemeNews';
    public $current = 0;
	public $group = 0;

	public function run()
	{
        if (!(int)$this->group)
            return;

        $group = NewsGroup::model()->findByPk($this->group);

		$this->render($this->tpl ,array(
            'group'=>$group,
            'current'=>$this->current,
        ));
	}

}