<?php
/** @var $model \app\modules\blog\models\Post */
?>
<?php Yii::app()->controller->reflash() ?>
<?php Yii::app()->controller->redirect($model->getUrl());
