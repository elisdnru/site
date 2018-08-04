<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

Yii::import('zii.widgets.CListView');

class DListView extends CListView
{
    public $noScript = false;

    public function __construct($owner=null)
    {
        $this->enableHistory = false;
        $this->ajaxUpdate = true;
        $this->template = "{items}\n{pager}";
        $this->cssFile = false;
        parent::__construct($owner);
    }

    public function registerClientScript()
    {
        if (!$this->noScript)
            parent::registerClientScript();
    }

}
