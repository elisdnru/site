<?php

Yii::import('application.modules.portfolio.models.*');
DUrlRulesHelper::import('portfolio');

class PortfolioWidget extends DWidget
{
    public $tpl = 'Portfolio';
	public $class = '';
	public $limit = 4;

	public function run()
	{
        PortfolioModule::registerScripts();

        $criteria = new CDbCriteria;
        $criteria->limit = $this->limit;
        $criteria->order = 'sort DESC';

        $items = PortfolioWork::model()->published()->cache(1000)->findAll($criteria);

		$this->render($this->tpl ,array(
            'items'=>$items,
        ));
	}
}