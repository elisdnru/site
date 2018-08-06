<?php

class DBreadcrumbsWidget extends DWidget
{
    public function run()
    {
        $this->render('BreadCrumbs', ['breadcrumbs' => Yii::app()->controller->breadcrumbs]);
    }
}
