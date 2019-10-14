<?php

namespace app\components\widgets;

use Yii;

class BreadcrumbsWidget extends Widget
{
    public function run(): void
    {
        $this->render('BreadCrumbs', ['breadcrumbs' => Yii::app()->controller->breadcrumbs]);
    }
}
