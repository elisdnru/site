<?php

namespace app\components\widgets;

use CWidget;
use Yii;

class BreadcrumbsWidget extends CWidget
{
    public function run(): void
    {
        $this->render('BreadCrumbs', ['breadcrumbs' => Yii::app()->controller->breadcrumbs]);
    }
}
