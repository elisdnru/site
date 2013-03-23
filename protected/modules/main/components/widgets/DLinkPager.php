<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DLinkPager extends CLinkPager
{
    public function __construct($owner=null)
    {
        $this->header ='';
        $this->prevPageLabel ='&laquo; назад';
        $this->nextPageLabel ='далее &raquo;';
        $this->cssFile = Yii::app()->theme->baseUrl . '/css/pager.css';
        $this->htmlOptions = array('class'=>'paginator');
        parent::__construct($owner);
    }
}
