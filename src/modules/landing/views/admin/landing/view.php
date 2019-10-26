<?php
use app\modules\landing\models\Landing;

/** @var $model Landing */
?>
<?php $this->context->reflash() ?>
<?php $this->redirect(['update', 'id' => $model->id]);
