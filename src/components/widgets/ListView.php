<?php

namespace app\components\widgets;

use CListView;
use Yii;

Yii::import('zii.widgets.CListView');

class ListView extends CListView
{
    public $template = "{items}\n{pager}";
    public $cssFile = false;

    public function registerClientScript(): void
    {

    }
}
