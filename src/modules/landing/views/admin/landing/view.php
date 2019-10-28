<?php
use app\modules\landing\models\Landing;

/** @var $model Landing */
?>
<?php Yii::app()->controller->reflash() ?>
<?php Yii::app()->controller->redirect(['update', 'id' => $model->id]);
