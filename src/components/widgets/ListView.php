<?php

namespace app\components\widgets;

use CListView;
use Yii;

Yii::import('zii.widgets.CListView');

class ListView extends CListView
{
    public $noScript = false;

    public function __construct($owner = null)
    {
        $this->enableHistory = false;
        $this->ajaxUpdate = true;
        $this->template = "{items}\n{pager}";
        $this->cssFile = false;
        parent::__construct($owner);
    }

    public function registerClientScript()
    {
        if (!$this->noScript) {
            parent::registerClientScript();
        }
    }
}
