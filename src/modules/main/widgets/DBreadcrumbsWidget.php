<?php

namespace app\modules\main\widgets;

use DWidget;
use Yii;

class DBreadcrumbsWidget extends DWidget
{
    public function run()
    {
        $this->render('BreadCrumbs', ['breadcrumbs' => Yii::app()->controller->breadcrumbs]);
    }
}
