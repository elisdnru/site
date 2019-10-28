<?php
/** @var $model Page */

use app\modules\page\models\Page;

?>
<?php Yii::app()->controller->reflash() ?>
<?php Yii::app()->controller->redirect($model->getUrl());
