<?php

namespace app\components\widgets;

use Yii;

class BreadcrumbsWidget extends Widget
{
    public function run()
    {
        $this->render('BreadCrumbs', ['breadcrumbs' => Yii::app()->controller->breadcrumbs]);
    }
}
