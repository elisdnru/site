<?php

namespace app\modules\main\widgets;

use app\modules\main\components\widgets\Widget;
use Yii;

class BreadcrumbsWidget extends Widget
{
    public function run()
    {
        $this->render('BreadCrumbs', ['breadcrumbs' => Yii::app()->controller->breadcrumbs]);
    }
}
