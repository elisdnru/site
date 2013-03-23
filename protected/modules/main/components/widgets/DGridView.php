<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

Yii::import('zii.widgets.grid.CGridView');

class DGridView extends CGridView
{
    public function __construct($owner=null)
    {
        $this->enableHistory = false;
        $this->cssFile = Yii::app()->request->baseUrl . '/core/css/gridview.css';
        $this->summaryText = '{start}&ndash;{end} из {count}';
        $this->pager= array(
            'class'=>'DLinkPager',
        );
        parent::__construct($owner);
    }
}
