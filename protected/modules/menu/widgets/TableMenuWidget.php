<?php

DUrlRulesHelper::import('menu');

class TableMenuWidget extends DWidget
{
	public $items=array();

	public function run()
	{
        echo CHtml::openTag('table');

        foreach ($this->items as $item)
        {
            echo CHtml::openTag('td', array('class'=>$item['active'] ? 'active' : ''));
            echo CHtml::link(CHtml::encode($item['label']), $item['url']);
            echo CHtml::closeTag('td')    ;
        }

        echo CHtml::closeTag('table');
	}
}