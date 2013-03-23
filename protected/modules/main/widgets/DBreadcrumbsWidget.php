<?php

class DBreadcrumbsWidget extends DWidget
{
     public function run()
     {
          $this->render('BreadCrumbs', array('breadcrumbs'=>Yii::app()->controller->breadcrumbs));
     }
}
